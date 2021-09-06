<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invitation extends Model
{
    use HasFactory;

    use HasUuids;

    protected $guarded = [];

    protected $casts = [
        'board_id' => 'integer',
    ];

    public function getAvatarAttribute(): string
    {
        $email = md5($this->email);
        $default = urlencode('https://www.w3schools.com/w3css/img_avatar2.png');
        return "https://www.gravatar.com/avatar/{$email}?d={$default}&s=40";
    }

    public function board(): BelongsTo
    {
        return $this->belongsTo(Board::class);
    }
}
