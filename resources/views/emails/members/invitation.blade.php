@component('mail::message')

# You have been invited to {{ $invitation->board->name }}

Hi {{ $username }},

You have been invited to **{{ $invitation->board->name }}**.

You can click the button below to join the board.

If you don't want to join this board, you can ignore this email.

@component('mail::button', ['url' => route('invitations.check')])
Join {{ $invitation->board->name }}
@endcomponent

Thank you!<br />
{{ config('app.name') }}

@endcomponent
