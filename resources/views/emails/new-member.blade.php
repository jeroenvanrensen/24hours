@component('mail::message')

# {{ $membership->user->first_name }} has joined {{ $membership->board->name }}

Hi {{ $receiver->first_name }},

{{ $membership->user->name }} (<{{ $membership->user->email }}>) has joined {{ $membership->board->name }} by {{ $membership->board->user->name }}.

Thank you,<br />
{{ config('app.name') }}

@endcomponent
