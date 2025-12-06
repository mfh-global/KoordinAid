<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Size extends Model
{
    use HasFactory, Searchable;

    protected $fillable = ['name', 'boxtribute_id', 'size_sort_index'];

    public function boxes()
    {
        return $this->hasMany(Box::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'boxtribute_id' => $this->boxtributeId
        ];
    }
}
