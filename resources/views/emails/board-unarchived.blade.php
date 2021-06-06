@component('mail::message')

# {{ $board->name }} was unarchived

Hi {{ $receiver->first_name }},

The board **{{ $board->name }}** by {{ $board->user->name }} was unarchived.

From now on you can edit the board's items.

Thank you,<br>
{{ config('app.name') }}

@endcomponent
