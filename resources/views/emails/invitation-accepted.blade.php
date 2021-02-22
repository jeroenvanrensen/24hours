@component('mail::message')

Hi {{ $membership->board->user->name }},

Your invitation to {{ $membership->user->name }} for {{ $membership->board->name }} has been accepted.

Thank you,<br />
{{ config('app.name') }}

@endcomponent
