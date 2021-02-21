@component('mail::message')

# You have been invited to {{ $invitation->board->name }}

Hi {{ App\Models\User::where('email', $invitation->email)->first()->name }},

You have been invited to **{{ $invitation->board->name }}**.

You can click the button below to join the board.

If you don't want to join this board, you can ignore this email.

@component('mail::button', ['url' => route('invitations.accept', $invitation)])
Join {{ $invitation->board->name }}
@endcomponent

Thank you!<br />
{{ config('app.name') }}

@endcomponent
