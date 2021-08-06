<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Link extends Model
{
    use HasFactory;

    protected $casts = [
        'board_id' => 'integer'
    ];

    protected $guarded = [];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($board) {
            $board->uuid = Str::uuid();
        });
    }

    public function board(): \Illuminate\Database\Eloquent\Relations\BelongsTo
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
