@component('mail::message')

Hi {{ $invitation->board->user->name }},

{{ $invitation->email }} has denied your invitation to {{ $invitation->board->name }}.

Thank you,<br />
{{ config('app.name') }}

@endcomponent
