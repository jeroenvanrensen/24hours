<?php

namespace App\Models;

use App\Mail\BoardArchivedMail;
use App\Mail\BoardUnarchivedMail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;

class Board extends Model
{
    use HasFactory;

    use HasUuids;

    protected $guarded = [];

    protected $casts = [
        'user_id' => 'integer',
        'archived' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function links(): HasMany
    {
        return $this->hasMany(Link::class);
    }

    public function notes(): HasMany
    {
        return $this->hasMany(Note::class);
    }

    public function invitations(): HasMany
    {
        return $this->hasMany(Invitation::class);
    }

    public function memberships(): HasMany
    {
        return $this->hasMany(Membership::class);
    }

    public function getItemsAttribute(): Collection
    {
        return collect([$this->notes, $this->links])->flatten();
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
