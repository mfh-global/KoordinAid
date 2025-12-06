<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organisation extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'phone_number',
        'organisation',
        'address',
        'city',
        'zipcode',
        'state',
        'e_mail',
        'country',
    ];

    public function requestedProducts()
    {
        return $this->belongsToMany(
            Product::class,
            'inquiry_id',
            'requested_products',
            'organisation_id',
            'product_id'
        )->withPivot('amount');
    }
}
