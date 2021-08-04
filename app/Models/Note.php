<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Note extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($board) {
            $board->uuid = Str::uuid();
        });
    }

    public function getWordCountAttribute(): int
    {
        return Str::of($this->body)
            ->replaceMatches('#<[^>]+>#', ' ') // Strip tags
            ->replaceMatches('/(I)\'m/i', '$1 am') // I'm -> I am
            ->replaceMatches('/(You)\'re/i', '$1 are') // You're -> You are
            ->replaceMatches('/(He|She|It)\'s/i', '$1 is') // He's / She's / It's -> He is / She is / It is
            ->replaceMatches('/(We)\'re/i', '$1 are') // We're -> We are
            ->replaceMatches('/(They)\'re/i', '$1 are') // They're -> They are
            ->wordCount();
    }

    public function board(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Board::class);
    }
}
