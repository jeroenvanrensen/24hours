@component('mail::message')

# {{ $membership->user->first_name }} left {{ $membership->board->name }}

Hi {{ $receiver->first_name }},

{{ $membership->user->name }} (<{{ $membership->user->email }}>) has left the board {{ $membership->board->name }}.

From now on {{ $membership->user->first_name }} can't see any of the boards items anymore.

Thank you,<br>
{{ config('app.name') }}

@endcomponent
