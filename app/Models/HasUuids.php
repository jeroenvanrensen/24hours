<?php

namespace App\Models;

use Illuminate\Support\Str;

trait HasUuids
{
    public static function bootHasUuids(): void
    {
        static::creating(function ($model) {
            $model->uuid = Str::uuid();
        });
    }
}
