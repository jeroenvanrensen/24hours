@component('mail::message')

# Board {{ $board->name }} deleted

Hi {{ $membership->user->first_name }},

The board {{ $board->name }} is deleted by {{ $board->user->name }}.

This means you can't see any of the board's items anymore.

Thank you,<br />
{{ config('app.name') }}

@endcomponent
