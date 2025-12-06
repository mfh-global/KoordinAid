<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Laravel\Scout\Searchable;

class Product extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'name',
        'gender',
        'boxtribute_id',
        'category_id',
        'size_range',
        'description',
        'is_inquireable'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function box()
    {
        return $this->hasMany(Box::class);
    }

    public function sizes()
    {
        return $this->belongsToMany(Size::class);
    }

    public function inquired_products()
    {
        return $this->hasMany(InquiredProduct::class, 'product_id');
    }

    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'gender' => $this->gender,
            'size_range' => $this->size_range,
            'category' => $this->category->name,
            'description' => $this->description
        ];
    }

    public function getProducts($request)
    {
        return $this->leftJoin('boxes', 'boxes.product_id', '=', 'products.id')
                    ->join('categories', 'categories.id', '=', 'products.category_id')
                    ->groupBy('products.id', 'categories.name')
                    ->filter($request->only('search'))
                    ->orderBy('categories.name')
                    ->orderBy('products.name')
                    ->select('products.*', 'categories.name as category', DB::raw('SUM(boxes.number_of_items) as in_stock'))
                    ->paginate(10)
                    ->withQueryString();
    }

    public function getRequestableProducts($request)
    {
        $forbiddenProducts = [146, 147, 148, 128]; // mixed items [special case] clothing, hygiene, shoes; ohne best. Kat.
        return $this->join('categories', 'categories.id', '=', 'products.category_id')
                    ->whereNotIn('products.id', $forbiddenProducts)
                    ->where('products.is_inquireable', 1)
                    ->groupBy('products.id', 'categories.name')
                    ->filter($request->only('search'))
                    ->orderBy('categories.name')
                    ->orderBy('products.name')
                    ->select('products.*', 'categories.name as category')
                    ->paginate(10)
                    ->withQueryString();
    }

    public function getSizesForProduct(int $id)
    {
        $forbiddenSizes = ["XXL", "XL", "XS", "34", "35"];
        return $this->join('product_size', 'products.id', '=', 'product_size.product_id')
            ->join('sizes', 'product_size.size_id', '=', 'sizes.id')
            ->where('products.id', '=', $id)
            ->whereNotIn('sizes.name', $forbiddenSizes)
            ->orderBy('sizes.size_sort_index')
            ->select('products.id', 'sizes.name', 'sizes.id')
            ->get();
    }    

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $searchResults = self::search($search)
                ->keys()
                ->toArray();
            $searchResultsList = implode(',', $searchResults);
            $query->whereIn('products.id', $searchResults)
                ->orderByRaw("FIELD(products.id,$searchResultsList)");
        });
    }
}
