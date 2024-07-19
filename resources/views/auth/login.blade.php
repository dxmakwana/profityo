<title>Login | Profityo</title>
<x-guest-layout>
    
    <h5 class="login-box-msg">Login !</h5>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="input-group mb-2">
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-regular fa-user"></span>
                </div>
            </div>
            <x-text-input id="email" class="form-control" type="email" name="email" :value="old('email',$rememberedEmail)" 
                autofocus autocomplete="email" placeholder="Email" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>
     
        <div class="input-group mb-1">
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-regular fa-eye"></span>
                </div>
            </div>
            <x-text-input id="password" class="form-control" type="password" name="password" 
                autocomplete="current-password" placeholder="Password" :value="old('password',$rememberedPassword)" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="block mt-2 d-flex justify-content-between">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember" {{ $rememberedRemeber == true ? 'checked' : '' }} />
                    <span class="ms-2 font_18">{{ __('Remember me') }}</span>
            </label>
            <p class="mb-0">
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="forgot_text">{{ __('Forgot your password?') }}</a>
                @endif
            </p>
        </div>

        <div class="flex items-center justify-end mt-3">
            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>