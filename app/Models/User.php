<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    protected $guarded = [];

    protected $hidden = [
        'password', 'remember_token'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime'
    ];

    public function getFirstNameAttribute(): string
    {
        return explode(' ', $this->name)[0];
    }

    public function boards()
    {
        return $this->hasMany(Board::class);
    }

    public function links()
    {
        return $this->hasManyThrough(Link::class, Board::class);
    }

    public function notes()
    {
        return $this->hasManyThrough(Note::class, Board::class);
    }
}
