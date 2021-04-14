<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Note extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($board) {
            $board->uuid = Str::uuid();
        });
    }

    public function getWordCountAttribute(): int
    {
        $text = Str::of($this->body)
            ->replaceMatches('#<[^>]+>#', ' ') // Strip tags
            ->replaceMatches('/(I)\'m/i', '$1 am') // I'm
            ->replaceMatches('/(You)\'re/i', '$1 are') // You're
            ->replaceMatches('/(He|She|It)\'s/i', '$1 is') // He's / She's / It's
            ->replaceMatches('/(We)\'re/i', '$1 are') // We're
            ->replaceMatches('/(They)\'re/i', '$1 are'); // They're

        return str_word_count($text);
    }

    public function board()
    {
        return $this->belongsTo(Board::class);
    }
}
