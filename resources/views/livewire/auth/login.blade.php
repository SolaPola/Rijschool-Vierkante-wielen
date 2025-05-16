<?php

use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    #[Validate('required|string|email')]
    public string $email = '';

    #[Validate('required|string')]
    public string $password = '';

    public bool $remember = false;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->ensureIsNotRateLimited();

        if (!Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }

    /**
     * Ensure the authentication request is not rate limited.
     */
    protected function ensureIsNotRateLimited(): void
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => __('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the authentication rate limiting throttle key.
     */
    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->email) . '|' . request()->ip());
    }
}; ?>

<div>
    <div class="w-full max-w-6xl backdrop-blur-md p-8 rounded-2xl shadow-xl flex flex-col gap-6">

        <div class="text-center mb-4">
            <h2 class="text-2xl font-bold text-blue-900">{{ __('Log in to your account') }}</h2>
            <p class="mt-2 text-blue-900">{{ __('Enter your email and password below to log in') }}</p>
        </div>

        <!-- Session Status -->
            <x-auth-session-status class="text-center text-navy-800" :status="session('status')" />

        <form wire:submit="login" class="flex flex-col gap-6">
            <!-- Email Address -->
            <div class="space-y-2">
                <label for="email" class="block text-sm font-medium text-navy-800">{{ __('Email address') }}</label>
                <input wire:model="email" id="email" type="email" required autofocus autocomplete="email"
                    placeholder="email@example.com"
                    class="w-full px-4 py-2 bg-navy-300 text-white border border-navy-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400">
                @error('email')
                    <span class="text-sm text-navy-800">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password -->
            <div class="space-y-2 relative">
                <label for="password" class="block text-sm font-medium text-navy-800">{{ __('Password') }}</label>
                <input wire:model="password" id="password" type="password" required autocomplete="current-password"
                    placeholder="{{ __('Password') }}"
                    class="w-full px-4 py-2 bg-navy-300 text-navy-800 border border-navy-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400">
                @error('password')
                    <span class="text-sm text-navy-800">{{ $message }}</span>
                @enderror

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" wire:navigate
                        class="absolute end-0 top-0 text-sm text-navy-800 hover:text-navy-600 hover:underline">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif
            </div>

            <!-- Remember Me -->
            <div class="flex items-center">
                <input wire:model="remember" id="remember" type="checkbox"
                    class="w-4 h-4 text-yellow-400 border-white-300 bg-white rounded focus:ring-yellow-400">
                <label for="remember" class="ml-2 block text-sm text-blue-900">
                    {{ __('Remember me') }}
                </label>
            </div>

            <div class="flex items-center justify-end">
                <button type="submit"
                    class="w-full px-4 py-2 bg-yellow-500 hover:bg-yellow-400 text-navy-900 font-semibold rounded-lg transition">
                    {{ __('Log in') }}
                </button>
            </div>
        </form>

        @if (Route::has('register'))
            <div class="text-center text-sm text-blue-900">
                {{ __("Don't have an account?") }}
                <a href="{{ route('register') }}" wire:navigate
                    class="text-yellow-400 hover:text-yellow-300 hover:underline">{{ __('Sign up') }}</a>
            </div>
        @endif
    </div>
</div>
