@component('mail::message')

# {{ $board->name }} was archived

Hi {{ $receiver->first_name }},

The board **{{ $board->name }}** by {{ $board->user->name }} was archived.

This means you can't change anything. However, you're still allowed to see all items.

Thank you,<br>
{{ config('app.name') }}

@endcomponent
