<?php

namespace App\Model;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $guarded = []; // YOLO

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($review) {
            $review->{$review->getKeyName()} = (string) Str::uuid();
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