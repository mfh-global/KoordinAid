<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Inquiry extends Model
{
    protected $fillable = [
        'organisation_id',
        'inquiry_id',
        'status',
        'comment',
        'delivery_from',
        'delivery_until'
    ];

    public function inqueriedProducts()
    {
        return $this->hasMany(InquiredProduct::class);
    }

    public function getComment()
    {
        return $this->comment;
    }

    public function organisation()
    {
        return $this->belongsTo(Organisation::class);
    }

    public function scopeFilter($query, $status)
    {
        if (!$status) {
            return $query;
        }

        return $query->where('status', '=', $status);
    }

    protected static function booted()
    {
        parent::boot();

        static::creating(
            function ($model) {
                $model->inquiry_id = Str::uuid()->toString();
                $model->status = Status::New;
            }
        );
    }
}
