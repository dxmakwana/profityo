<x-guest-layout>
    <h5 class="login-box-msg">Login !</h5>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    @if(Session::has('forgotpassword-success'))
      <p class="text-success" > {{ Session::get('forgotpassword-success') }}</p>
    @endif
    @if(Session::has('forgotpassword-error'))
      <p class="text-danger" > {{ Session::get('forgotpassword-error') }}</p>
    @endif
    <form method="POST" action="{{ route('business.login.store') }}">
        @csrf

        <div class="input-group mb-2">
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-regular fa-user"></span>
                </div>
            </div>
            <x-text-input id="user_email" class="form-control" type="email" name="user_email" :value="old('user_email',$rememberedEmails)" 
                autofocus autocomplete="email" placeholder="Email" />
            <x-input-error :messages="$errors->get('user_email')" class="mt-2" />
        </div>
     
        <div class="input-group mb-1">
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-regular fa-eye"></span>
                </div>
            </div>
            <x-text-input id="user_password" class="form-control" type="password" name="user_password" :value="old('user_password',$rememberedPasswords)" 
                autocomplete="current-password" placeholder="Password" />
            <x-input-error :messages="$errors->get('user_password')" class="mt-2" />
        </div>

        <div class="block mt-2 d-flex justify-content-between">
            <label for="user_remember" class="inline-flex items-center">
                <input id="user_remember" type="checkbox"
                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="user_remember" {{ $rememberedRemebers == true ? 'checked' : '' }} />
                    <span class="ms-2 font_18">{{ __('Remember me') }}</span>
            </label>
            <p class="mb-0">
                @if (Route::has('business.password.request'))
                    <a href="{{ route('business.password.request') }}" class="forgot_text">{{ __('Forgot your password?') }}</a>
                @endif
            </p>
        </div>

        <div class="flex items-center justify-end mt-3">
            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
            <p class="text-center font_18">Don't have an account? <a href="{{ route('business.register') }}" class="back_text">Register</a></p>
        </div>
    </form>
</x-guest-layout>