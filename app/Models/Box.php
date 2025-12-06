<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Laravel\Scout\Searchable;

class Box extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'boxtribute_id',
        'number_of_items',
        'product_id',
        'size_id',
        'location_id',
        'label_identifier'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function size()
    {
        return $this->belongsTo(Size::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
   
    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'boxtribute_id' => $this->boxtributeId
        ];
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $searchResults = self::search($search)
                ->keys()
                ->toArray();
            $query->whereIn('id', $searchResults);
        });
    }
}
