@component('mail::message')

# {{ $membership->user->first_name }} accepted your invitation

Hi {{ $membership->board->user->first_name }},

Your invitation to {{ $membership->user->name }} (<{{ $membership->user->email }}>) for {{ $membership->board->name }} has been accepted.

Thank you,<br />
{{ config('app.name') }}

@endcomponent
