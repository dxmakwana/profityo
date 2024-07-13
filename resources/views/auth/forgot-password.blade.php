<x-guest-layout>
    <h5 class="login-box-msg">Forgot Password !</h5>

    <!-- Session Status -->
    <x-auth-session-status class="mb-2" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="input-group mb-3">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-regular fa-user"></span>
            </div>
          </div>
          <input id="email" class="form-control" type="email" name="email" :value="old('email')" required autofocus placeholder="Enter Your Email">
          <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>
        <button type="submit" class="btn login_btn mb-3">Send Password Reset Link</button>
        <p class="text-center font_18">Back to <a href="{{ route('login') }}" class="back_text">Login</a></p>
    </form>
</x-guest-layout>
