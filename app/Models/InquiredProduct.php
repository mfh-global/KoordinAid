<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InquiredProduct extends Model
{
    protected $fillable = [
        'product_id',
        'inquiry_id',
        'sizes'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function inquiry()
    {
        return $this->belongsTo(Inquiry::class);
    }

    public function organisation()
    {
        return $this->hasOneThrough(Organisation::class, Inquiry::class);
    }

    public function sizes()
    {
        return $this->belongsToMany(Size::class, 'inquired_product_sizes')
            ->withPivot('inquired_product_id')
            ->withPivot('number_of_items');
    }
}
