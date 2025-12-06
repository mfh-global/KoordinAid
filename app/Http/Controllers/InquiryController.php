<?php

namespace App\Http\Controllers;

use App\Models\Box;
use App\Models\InquiredProduct;
use App\Models\Inquiry;
use App\Models\Organisation;
use App\Models\Product;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Controller;
use Inertia\Inertia;

class InquiryController extends Controller
{
    public function create(Request $request): \Inertia\Response
    {
        return Inertia::render('Inquiry/Create', [
            'filters' => $request->all('search'),
            'products' => (new Product())->getRequestableProducts($request),
            'size' => Size::where('product_id', '=', $request->only('product_id'))
        ]);
    }

    public function getSize(Product $product)
    {
        return (new Product())->getSizesForProduct($product->id);
    }

    public function store(Request $request)
    {
        $organisation = Organisation::updateOrCreate(
            $request->validate([
                'full_name' => 'required|max:255',
                'phone_number' => 'max:255',
                'organisation' => 'required|max:255',
                'address' => 'required|max:255',
                'city' => 'required|max:255',
                'zipcode' => 'required|max:255',
                'state' => 'max:255',
                'country' => 'required|max:255',
                'e_mail' => 'required|max:255|email:rfc,dns',
            ])
        );
        $request->validateWithBag('products', [
            'products.*.id' => 'exists:products,id',
            'products.*.requested' => 'required|array',
            'products.*.requested.*' => 'integer|min:1',
            'products' => 'array|min:1',
        ], [
            'products.*.requested' => "Amount needs to be greater than 0 for all products in your inquiry. To remove an item use the 'delete' button.",
            'products.*.requested.*' => "Amount needs to be greater than 0 for all products in your inquiry. To remove an item use the 'delete' button.",
        ]);
        $request->validate([
            'delivery_from' => 'nullable|date',
            'delivery_until' => 'nullable|date'
        ]);

        $inquiry = new Inquiry();
        $inquiry->organisation_id = $organisation->id;
        $inquiry->comment = $request->comment ?? "";
        $inquiry->delivery_from = $request->delivery_from ?? null;
        $inquiry->delivery_until = $request->delivery_until ?? null;
        $inquiry->save();

        $this->saveInquiredProducts($request->products, $inquiry->id);

        return Redirect::to('/inquiry/success');
    }

    private function saveInquiredProducts(array $products, int $inquiryId): void
    {
        foreach ($products as $product) {
            $inquiredProduct = new InquiredProduct(
                [
                    'inquiry_id' => $inquiryId,
                    'product_id' => $product['id'],
                ]
            );
            $inquiredProduct->save();
            $inquiredProduct->sizes()->sync($this->getSizes($product['requested'], $inquiredProduct->id));
            $inquiredProduct->save();
        }

    }

    private function getSizes(array $requested, int $productId): array
    {
        $sizes = [];
        foreach ($requested as $sizeId => $numberOfItems) {
            $sizes[] = [
                'inquired_product_id' => $productId,
                'size_id' => $sizeId,
                'number_of_items' => $numberOfItems
            ];
        }

        return $sizes;
    }
}
