@component('mail::message')

# You are removed from {{ $membership->board->name }}

Hi {{ $membership->user->first_name }},

You are removed from the board {{ $membership->board->name }} by {{ $membership->board->user->name }}.

This means you can't see any of the board's items anymore.

Thank you,<br>
{{ config('app.name') }}

@endcomponent
