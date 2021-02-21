<div x-data="{ newMemberModal: false }" class="max-w-2xl mx-auto">
    <div class="mb-8 flex items-center justify-between">
        <h2 class="text-2xl md:text-3xl font-serif">Members</h2>
        <x-button @click="newMemberModal = true">Add member</x-button>
    </div>

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

    <livewire:members.create :board="$board" />
</div>
