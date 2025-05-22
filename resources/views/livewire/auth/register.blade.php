<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    public string $firstname = '';
    public string $infix = '';
    public string $lastname = '';
    public string $username = '';
    public string $birthdate = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'firstname' => ['required', 'string', 'max:255'],
            'infix' => ['nullable', 'string', 'max:50'],
            'lastname' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:' . User::class],
            'birthdate' => ['required', 'date', 'before:today'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);
        // Set default values for other required fields
        $validated['is_active'] = true;
        $validated['is_logged_in'] = false;
        $validated['logged_in'] = false;
        $validated['logged_out'] = false;

        event(new Registered(($user = User::create($validated))));

        Auth::login($user);

        $this->redirectIntended(route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div>
    <div class="w-full max-w-2xl bg-navy-800 backdrop-blur-md p-8 rounded-2xl shadow-xl flex flex-col gap-6">
        <div class="text-center mb-4">
            <h2 class="text-2xl font-bold text-blue-900">{{ __('Create an account') }}</h2>
            <p class="mt-2 text-blue-900">{{ __('Enter your details below to create your account') }}</p>
        </div>

        <!-- Session Status -->
        @if (session('status'))
            <div class="text-center text-sm font-medium text-yellow-400">
                {{ session('status') }}
            </div>
        @endif

        <form wire:submit="register" class="flex flex-col gap-6">
            <!-- First Name -->
            <div class="space-y-2">
                <label for="firstname" class="block text-sm font-medium text-blue-900">{{ __('First Name') }}</label>
                <input wire:model="firstname" id="firstname" type="text" required autofocus
                    placeholder="{{ __('First name') }}"
                    class="w-full px-4 py-2 bg-white text-gray-900 border border-navy-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400">
                @error('firstname')
                    <span class="text-sm text-yellow-400">{{ $message }}</span>
                @enderror
            </div>

            <!-- Infix -->
            <div class="space-y-2">
                <label for="infix" class="block text-sm font-medium text-blue-900">{{ __('Infix') }}</label>
                <input wire:model="infix" id="infix" type="text" placeholder="{{ __('Infix (optional)') }}"
                    class="w-full px-4 py-2 bg-white text-gray-900 border border-navy-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400">
                @error('infix')
                    <span class="text-sm text-yellow-400">{{ $message }}</span>
                @enderror
            </div>

            <!-- Last Name -->
            <div class="space-y-2">
                <label for="lastname" class="block text-sm font-medium text-blue-900">{{ __('Last Name') }}</label>
                <input wire:model="lastname" id="lastname" type="text" required placeholder="{{ __('Last name') }}"
                    class="w-full px-4 py-2 bg-white text-gray-900 border border-navy-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400">
                @error('lastname')
                    <span class="text-sm text-yellow-400">{{ $message }}</span>
                @enderror
            </div>

            <!-- Username -->
            <div class="space-y-2">
                <label for="username" class="block text-sm font-medium text-blue-900">{{ __('Username') }}</label>
                <input wire:model="username" id="username" type="text" required autocomplete="username"
                    placeholder="{{ __('Username') }}"
                    class="w-full px-4 py-2 bg-white text-gray-900 border border-navy-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400">
                @error('username')
                    <span class="text-sm text-yellow-400">{{ $message }}</span>
                @enderror
            </div>

            <!-- Birth Date -->
            <div class="space-y-2">
                <label for="birthdate" class="block text-sm font-medium text-blue-900">{{ __('Birth Date') }}</label>
                <input wire:model="birthdate" id="birthdate" type="date" required
                    placeholder="{{ __('Birth date') }}"
                    class="w-full px-4 py-2 bg-white text-gray-900 border border-navy-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400">
                @error('birthdate')
                    <span class="text-sm text-yellow-400">{{ $message }}</span>
                @enderror
            </div>

            <!-- Email Address -->
            <div class="space-y-2">
                <label for="email" class="block text-sm font-medium text-blue-900">{{ __('Email address') }}</label>
                <input wire:model="email" id="email" type="email" required autocomplete="email"
                    placeholder="email@example.com"
                    class="w-full px-4 py-2 bg-white text-gray-900 border border-navy-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400">
                @error('email')
                    <span class="text-sm text-yellow-400">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password -->
            <div class="space-y-2">
                <label for="password" class="block text-sm font-medium text-blue-900">{{ __('Password') }}</label>
                <input wire:model="password" id="password" type="password" required autocomplete="new-password"
                    placeholder="{{ __('Password') }}"
                    class="w-full px-4 py-2 bg-white text-gray-900 border border-navy-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400">
                @error('password')
                    <span class="text-sm text-yellow-400">{{ $message }}</span>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="space-y-2">
                <label for="password_confirmation"
                    class="block text-sm font-medium text-blue-900">{{ __('Confirm password') }}</label>
                <input wire:model="password_confirmation" id="password_confirmation" type="password" required
                    autocomplete="new-password" placeholder="{{ __('Confirm password') }}"
                    class="w-full px-4 py-2 bg-white text-gray-900 border border-navy-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400">
                @error('password_confirmation')
                    <span class="text-sm text-yellow-400">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex items-center justify-end">
                <button type="submit"
                    class="w-full px-4 py-2 bg-yellow-500 hover:bg-yellow-400 text-navy-900 font-semibold rounded-lg transition">
                    {{ __('Create account') }}
                </button>
            </div>
        </form>

        <div class="text-center text-sm text-blue-900">
            {{ __('Already have an account?') }}
            <a href="{{ route('login') }}" wire:navigate
                class="text-yellow-400 hover:text-yellow-300 hover:underline">{{ __('Log in') }}</a>
        </div>
    </div>
</div>
