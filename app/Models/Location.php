<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Location extends Model
{
    use HasFactory, Searchable;

    protected $fillable = ['name', 'boxtribute_id'];


    public function boxes()
    {
        return $this->hasMany(Box::class); // ::class for full class name (including namespace)
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
