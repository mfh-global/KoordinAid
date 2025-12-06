<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Category extends Model
{
    use HasFactory, Searchable;

    protected $fillable = ['name', 'boxtribute_id'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'boxtribute_id' => $this->boxtributeId,
            'name' => $this->name,
        ];
    }
}
