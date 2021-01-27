<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function board()
    {
        return $this->belongsTo(Board::class);
    }

    public function getHostAttribute(): string
    {
        return str_replace('www.', '', parse_url($this->url)['host']);
    }

    public function getDefaultImageAttribute(): string
    {
        return asset('img/image-not-found.png');
    }
}
