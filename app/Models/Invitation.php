<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Invitation extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'board_id' => 'integer'
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($board) {
            $board->uuid = Str::uuid();
        });
    }

    public function getAvatarAttribute(): string
    {
        $email = md5($this->email);
        $default = urlencode('https://www.w3schools.com/w3css/img_avatar2.png');
        return "https://www.gravatar.com/avatar/$email?d=$default&s=40";
    }

    public function board(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Board::class);
    }
}
