<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($board) {
            $board->uuid = Str::uuid();
        });
    }

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

    public function memberships()
    {
        return $this->hasMany(Membership::class);
    }

    public function visibleBoards()
    {
        return $this->memberships->map(function($membership) {
            return $membership->board;
        })->merge($this->boards)->sortByDesc('updated_at');
    }

    public function visibleLinks()
    {
        return $this->memberships->map(function($membership) {
            return $membership->board->links;
        })->flatten()->merge($this->links)->sortByDesc('updated_at');
    }

    public function visibleNotes()
    {
        return $this->memberships->map(function($membership) {
            return $membership->board->notes;
        })->flatten()->merge($this->notes)->sortByDesc('updated_at');
    }
}
