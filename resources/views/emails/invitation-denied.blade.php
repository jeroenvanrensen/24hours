@component('mail::message')

# {{ $invitation->email }} denied your invitation

Hi {{ $invitation->board->user->first_name }},

{{ $invitation->email }} has denied your invitation to {{ $invitation->board->name }}.

Thank you,<br />
{{ config('app.name') }}

@endcomponent
