<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    protected $guarded = [];

    protected static function boot(): void
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

    public function boards(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Board::class);
    }

    public function links(): \Illuminate\Database\Eloquent\Relations\HasManyThrough
    {
        return $this->hasManyThrough(Link::class, Board::class);
    }

    public function notes(): \Illuminate\Database\Eloquent\Relations\HasManyThrough
    {
        return $this->hasManyThrough(Note::class, Board::class);
    }

    public function memberships(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Membership::class);
    }

    public function visibleBoards(): Collection
    {
        return $this->memberships->map(function ($membership) {
            return $membership->board;
        })->merge($this->boards)->sortByDesc('updated_at');
    }

    public function visibleLinks(): Collection
    {
        return $this->memberships->map(function ($membership) {
            return $membership->board->links;
        })->flatten()->merge($this->links)->sortByDesc('updated_at');
    }

    public function visibleNotes(): Collection
    {
        return $this->memberships->map(function ($membership) {
            return $membership->board->notes;
        })->flatten()->merge($this->notes)->sortByDesc('updated_at');
    }
}
