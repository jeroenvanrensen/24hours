<?php

namespace App\Http\Controllers\Links;

use App\Models\Link;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Show
{
    use AuthorizesRequests;

    public function __invoke(Link $link)
    {
        $this->authorize('view', $link->board);

        $link->update(['updated_at' => now()]);

        return redirect()->to($link->url);
    }
}
