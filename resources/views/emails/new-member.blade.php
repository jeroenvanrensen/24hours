@component('mail::message')

Hi {{ $receiver->name }},

{{ $membership->user->name }} <{{ $membership->user->email }}> has joined **{{ $membership->board->name }}** by {{ $membership->board->user->name }}.

Thank you,<br />
{{ config('app.name') }}

@endcomponent
