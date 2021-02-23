@component('mail::message')

Hi {{ $membership->user->name }},

The board **{{ $board->name }}** is deleted by {{ $board->user->name }}.

This means you can't see any of the board's items anymore.

Thank you,<br />
{{ config('app.name') }}

@endcomponent
