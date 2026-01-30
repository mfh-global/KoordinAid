<?php

namespace App\Boxtribute\Importer;

use App\Boxtribute\BoxtributePaginationInput;
use App\Boxtribute\Queries\Products;
use App\Models\Category;
use App\Models\Product;
use App\Models\Box;
use App\Models\InquiredProduct;
use App\Models\inquiredProductSize;
use App\Models\Size;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\QueryException; 

class BoxtributeProductImporter implements BoxtributeImporter
{
    private const SKIP_PRODUCTS = ["11351", "11352", "11388"]; // Product_ids of Mixed Items Boxes
    private readonly array $sizeSortIndex;

    public function __construct(
        private readonly Products $productsQuery
    ) {
        $this->sizeSortIndex = json_decode(Storage::get("size_sort.json"), true);
    }

    public function import(): void
    {
        $paginationInput = new BoxtributePaginationInput(50);
        $hasNextPage = true;
        while ($hasNextPage) {
            $products = $this->productsQuery->execute($paginationInput->getInput())['data']['products'];
            $this->importProducts($products);
            $hasNextPage = $products['pageInfo']['hasNextPage'];
            $paginationInput = new BoxtributePaginationInput(50, $products['pageInfo']['endCursor']);
        }
        Product::where('boxtribute_id', 5537)->update(
            [
                'is_inquireable' => false,
            ]);
    }

    private function importProducts(array $products): array
    {
        $importedProducts =  [];
        foreach($products['elements'] as $product) {
            Log::info("importing {$product["name"]}, id: {$product["id"]}");
            $is_inquireable = true;
            if ((! is_null($product['deletedOn']) ) or (in_array($product['id'], self::SKIP_PRODUCTS))){
                $is_inquireable = false;
            }
            $category = Category::updateOrCreate(
                ['boxtribute_id' => $product['category']['id']],
                ['name' => $product['category']['name']]
            );
            $sizeIds = $this->importSize($product);
            $product = $this->importProduct($product, $category, $is_inquireable);

            $product->sizes()->sync($sizeIds);
            $product->save();
            $importedProducts[] =  $product['id']; // local id
        }
        return $importedProducts;
    }

    private function importSize(array $product): array
    {
        $sizeIds = [];
        foreach ($product['sizeRange']['sizes'] as $size) {
            $sizeIds[] = Size::updateOrCreate(
                ['boxtribute_id' => $size['id']],
                [
                    'name' => $size['label'],
                    'size_sort_index' => array_search($size['label'], $this->sizeSortIndex) ?: null
                ]
            )->id;
        }
        return $sizeIds;
    }

    private function importProduct(array $product, Category $category, bool $is_inquireable): Product
    {
        return Product::updateOrCreate(
            ['boxtribute_id' => $product['id']],
            [
                'gender' => $product['gender'],
                'name' => $product['name'],
                'category_id' => $category->id,
                'size_range' => $product['sizeRange']['label'],
                'description' => $product['comment'] ?? "",
                'is_inquireable' => $is_inquireable,
            ]
        );
    }
}