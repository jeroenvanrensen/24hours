<?php

namespace App\Models;

use App\Mail\BoardArchivedMail;
use App\Mail\BoardUnarchivedMail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class Board extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'archived' => 'boolean'
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($board) {
            $board->uuid = Str::uuid();
        });
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function links(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Link::class);
    }

    public function notes(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Note::class);
    }

    public function invitations(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Invitation::class);
    }

    public function memberships(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Membership::class);
    }

    public function getItemsAttribute(): Collection
    {
        return $this->notes->push($this->links)->flatten();
    }

    public function archive(): void
    {
        $this->update(['archived' => true]);

        collect($this->memberships)
            ->map(fn ($membership) => $membership->user)
            ->each(fn ($member) => Mail::to($member)->queue(new BoardArchivedMail($this, $member)));
    }

    public function unarchive(): void
    {
        $this->update(['archived' => false]);

        collect($this->memberships)
            ->filter(fn ($membership) => $membership->role == 'member')
            ->map(fn ($membership) => $membership->user)
            ->each(fn ($member) => Mail::to($member)->queue(new BoardUnarchivedMail($this, $member)));
    }
}
