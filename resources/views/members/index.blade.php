<div>
    <x-heading>Board members</x-heading>

    <div class="max-w-xl mx-auto">
        <ul>
            <li>
                <strong class="block">{{ $board->user->name }}</strong>
                <span>Owner</span>
            </li>

            @foreach($board->memberships as $membership)
                <li>
                    <strong class="block">{{ $membership->user->name }}</strong>
                    <span>{{ ucfirst($membership->role) }}</span>
                </li>
            @endforeach
        </ul>
    </div>

    <livewire:members.create :board="$board" />
</div>
