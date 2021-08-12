<div>
    <x-auth-card>
        <h1 class="mb-8 text-3xl font-semibold">Sign in to <span class="text-indigo-600">{{ config('app.name') }}</span></h1>

        <!-- Email -->
        <x-form-group>
            <x-label for="email">Email</x-label>
            <x-input name="email" autofocus wire:model.defer="email" />
            <x-form-error name="email" />
        </x-form-group>

        <!-- Password -->
        <x-form-group>
            <x-label for="password">Password</x-label>
            <x-input name="password" autofocus wire:model.defer="password" />
            <x-form-error name="password" />
        </x-form-group>

        <!-- Submit Button -->
        <x-card-footer>
            <a href="{{ route('password.request') }}" class="text-sm font-medium text-indigo-600 outline-none hover:text-indigo-700 focus:text-indigo-800">Forgot your password?</a>
            <x-button wire:click="login">Sign In</x-button>
        </x-card-footer>
    </x-auth-card>
</div>
