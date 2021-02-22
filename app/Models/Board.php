<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Board extends Model
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function links()
    {
        return $this->hasMany(Link::class);
    }

    public function notes()
    {
        return $this->hasMany(Note::class);
    }

    public function invitations()
    {
        return $this->hasMany(Invitation::class);
    }

    public function memberships()
    {
        return $this->hasMany(Membership::class);
    }

    public function getItemsAttribute()
    {
        return $this->notes->push($this->links)->flatten();
    }
}
