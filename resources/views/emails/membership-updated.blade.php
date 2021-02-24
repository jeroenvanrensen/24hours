@component('mail::message')

# Your membership has been updated

Hi {{ $membership->user->first_name }},

Your membership for {{ $membership->board->name }} has been updated by {{ $membership->board->user->name }}. Your current role is **{{ $membership->role }}**.

@if($membership->role == 'member')
From now on you can manage links and notes.
@else
From now on you can't manage links and notes anymore.
@endif

Thank you,<br />
{{ config('app.name') }}

@endcomponent
