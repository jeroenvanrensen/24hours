<div>
    <x-auth.card>
        <h1 class="text-2xl mb-6">Login</h1>

        <!-- Email -->
        <x-forms.group>
            <x-forms.label for="email">Email</x-forms.label>
            <x-forms.input type="email" name="email" id="email" autofocus wire:model.lazy="email" />
            <x-forms.error name="email" />
        </x-forms.group>

        <!-- Password -->
        <x-forms.group>
            <x-forms.label for="password">Password</x-forms.label>
            <x-forms.input type="password" name="password" id="password" autofocus wire:model.lazy="password" />
            <x-forms.error name="password" />
        </x-forms.group>

        <!-- Submit Button -->
        <div class="flex justify-end items-center">
            <a href="{{ route('password.request') }}" class="text-sm text-gray-600 underline hover:text-gray-800 focus:text-black dark:text-gray-400 dark:hover:text-gray-200 dark:focus:text-white outline-none">Forgot your password?</a>
            <x-button class="ml-4" wire:click="login" loading="login">Sign In</x-button>
        </div>
    </x-auth.card>
</div>
