@component('mail::message')

# {{ $membership->user->first_name }} is removed from {{ $membership->board->name }}

Hi {{ $receiver->first_name }},

{{ $membership->user->name }} is removed from {{ $membership->board->name }}.

This means {{ $membership->user->first_name }} can't see any of the board's items anymore.

Thank you,<br />
{{ config('app.name') }}

@endcomponent
