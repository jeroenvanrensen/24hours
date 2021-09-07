<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    use HasFactory;

    use HasUuids;

    protected $guarded = [];

    protected $casts = [
        'board_id' => 'integer',
        'user_id' => 'integer',
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function board(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Board::class);
    }
}
