<title>Forgot Password | Profityo</title>
<x-guest-layout>
    <h5 class="login-box-msg">Forgot Password !</h5>

    <!-- Session Status -->
    <x-auth-session-status class="mb-2" :status="session('status')" />
    @if(Session::has('forgotpassword-link-success'))
      <p class="text-success" > {{ Session::get('forgotpassword-link-success') }}</p>
    @endif
    @if(Session::has('forgotpassword-link-error'))
      <p class="text-danger" > {{ Session::get('forgotpassword-link-error') }}</p>
    @endif

    <form method="POST" action="{{ route('business.password.email') }}">
        @csrf
        <div class="input-group mb-3">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-regular fa-user"></span>
            </div>
          </div>
          <input id="user_email" class="form-control" type="email" name="user_email" :value="old('user_email')" autofocus placeholder="Enter Your Email">
          <x-input-error :messages="$errors->get('user_email')" class="mt-2" />
        </div>
        <button type="submit" class="btn login_btn mb-3">Send Password Reset Link</button>
        <p class="text-center font_18">Back to <a href="{{ route('business.login') }}" class="back_text">Login</a></p>
    </form>
</x-guest-layout>
