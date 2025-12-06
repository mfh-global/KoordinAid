<?php

namespace App\Boxtribute\Importer;

use App\Boxtribute\BoxtributePaginationInput;
use App\Boxtribute\Queries\Location as LocationQuery;
use App\Models\Box;
use App\Models\Location;
use App\Models\Product;
use App\Models\Category;
use App\Models\Size;
use Illuminate\Support\Facades\Log;

class BoxtributeLocationImporter implements BoxtributeImporter
{
    const ID_OTHER = 5537;
    const ID_STOCKROOM = "94";

    // import only boxes from following locations:
    // 94 = stockroom, 80 = openboxes
    const IN_STOCK_LOCATIONS = [94, 80];

    public function __construct(private readonly LocationQuery $locationQuery)
    {}

    public function import(): void
    {
        foreach (self::IN_STOCK_LOCATIONS as $location_id) {
            $location = $this->locationQuery->execute([
                'id' => $location_id,
                ...(new BoxtributePaginationInput(50))->getInput()
            ])['data']['location'];

            $localLocation = Location::updateOrCreate(
                ['boxtribute_id' => $location_id],
                ['name' => $location['name']]
            );

            $importedBoxes = $this->importBoxes($location, $location_id, $localLocation);
       }

       Box::whereNotIn('boxtribute_id', $importedBoxes)->delete();
    }

    /**
     * @return int[] array with imported boxes by their id from boxtribute
     */
    private function importBoxes(array $location, int $boxtributeLocationId, Location $izToolLocation): array
    {
        $importedBoxes = [];
        while (true) {
            foreach ($location['boxes']['elements'] as $box) {
                $box = $this->importBox($box, $izToolLocation);
                if ($box) {
                    $importedBoxes[] = $box->boxtribute_id;
                }
            }

            $hasNextPage = $location['boxes']['pageInfo']['hasNextPage'];

            if (!$hasNextPage) break;

            $location = $this->locationQuery->execute([
                'id' => $boxtributeLocationId,
                ...(new BoxtributePaginationInput(50, $location['boxes']['pageInfo']['endCursor']))->getInput()
            ])['data']['location'];
        }
        return $importedBoxes;
    }

    private function importBox(array $box, Location $izToolLocation): ?Box
    {
        foreach ($box['history'] as $record){
            if (in_array("Record deleted", $record)){
                return null;
            }
        }

        if ($box['state'] !== 'InStock'){
            return null;
        }

        Log::info("importing box id: {$box["id"]}");

        $boxtributeId = $box['id'];
        if ((int) $box['product']['id'] === self::ID_OTHER){
            $product = $this->createNewProductFromComment($box);
        }  else {
            $product = Product::firstWhere('boxtribute_id', $box['product']['id']);
        }

        $sizeId = Size::firstWhere('boxtribute_id', $box['size']['id'])->id;

        return Box::updateOrCreate(
            ['boxtribute_id' => $boxtributeId],
            [
                'number_of_items' => $box['numberOfItems'],
                'product_id' => $product->id,
                'location_id' => $izToolLocation->id,
                'size_id' => $sizeId,
                'label_identifier' => $box['labelIdentifier']
            ]
        );
    }

    /**
     * @return integer boxtribute_id of the (maybe new) product
     */
    private function createNewProductFromComment($box): Product
    {
        $productName = trim(preg_replace( // filter weight
        "/[0-9]{1,}(,|\.)?([0-9]{1,})?(?i:kg)?(,|;)?/m", '',$box['comment']));
        if (strlen($productName) === 0){
            $productName = "Schrödinger's fox";
        } else{
            $productName = "Other: ".$productName;
        }
        return Product::updateOrCreate(
            ['boxtribute_id' => $box['product']['id'], 'name' => $productName],
            [
                'gender' => 'none',
                'category_id' => Category::firstWhere('boxtribute_id', 9)->id,
                'size_range' => 'Mixed sizes',
                'description'  => 'no description available',
                'is_inquireable' => true,
            ]
        );
    }


}