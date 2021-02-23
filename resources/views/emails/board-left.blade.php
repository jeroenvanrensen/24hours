@component('mail::message')

Hi {{ $receiver->name }},

{{ $membership->user->name }} has left the board {{ $membership->board->name }}.

Thank you,<br>
{{ config('app.name') }}

@endcomponent
