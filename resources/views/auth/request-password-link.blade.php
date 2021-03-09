<div>
    <x-auth.card>
        <h1 class="mb-6 text-2xl">Forgot Password</h1>

        <p class="mb-6"> Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.</p>

        <!-- Email -->
        <x-forms.group>
            <x-forms.label for="email">Email</x-forms.label>
            <x-forms.input type="email" name="email" id="email" wire:model="email" />
            <x-forms.error name="email" />
        </x-forms.group>

        <!-- Submit Button -->
        <div class="flex items-center justify-end">
            @if(session()->has('success'))
                <span class="text-sm text-gray-600">{{ session()->get('success') }}</span>
            @endif
            @if(session()->has('error'))
                <span class="text-sm text-red-700">{{ session()->get('error') }}</span>
            @endif

            <x-button class="ml-4" wire:click="request">Send Link</x-button>
        </div>
    </x-auth.card>
</div>
