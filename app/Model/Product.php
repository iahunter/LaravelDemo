<?php

namespace App\Model;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = []; // YOLO

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            $product->{$product->getKeyName()} = (string) Str::uuid();
        });
    }

    public function getIncrementing()
    {
        return false;
    }

    public function getKeyType()
    {
        return 'string';
    }
}
