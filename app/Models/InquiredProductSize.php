<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class inquiredProductSize extends Model
{
    protected $fillable = [
        'product_id',
        'size_id',
        'number_of_items'
    ];
}
