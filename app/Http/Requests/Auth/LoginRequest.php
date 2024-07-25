<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Cookie;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();
    
        $credentials = $this->only('email', 'password');
        $user = User::where('email', $credentials['email'])->first();
    
        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            RateLimiter::hit($this->throttleKey());
    
            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }
    
        // Log the user in with the 'masteradmins' guard
        Auth::guard('web')->login($user, $this->boolean('remember'));
    
        // Also log the user in with the second guard, for example 'secondguard'
        Auth::guard('web')->setUser($user);

        if ($this->boolean('remember')) {
            Cookie::queue(Cookie::make('email', $this->input('email'), 60 * 24 * 30)); // 30 days
            Cookie::queue(Cookie::make('password', $this->input('password'), 60 * 24 * 30)); // 30 days
            Cookie::queue(Cookie::make('remember', $this->boolean('remember'), 60 * 24 * 30));
        } else {
            Cookie::queue(Cookie::forget('email'));
            Cookie::queue(Cookie::forget('password'));
            Cookie::queue(Cookie::forget('remember'));
        }
        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('email')).'|'.$this->ip());
    }
}
