<?php

namespace App\Http\Requests\Auth\Masteradmin;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use App\Models\MasterUser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;

class MasterLoginRequest extends FormRequest
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
            'user_email' => ['required', 'string', 'email'], // corrected rule
            'user_password' => ['required', 'string'],
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
    
        $credentials = $this->only('user_email', 'user_password');
        $user = MasterUser::where('user_email', $credentials['user_email'])->first();
    
        if (! $user || ! Hash::check($credentials['user_password'], $user->user_password)) {
            RateLimiter::hit($this->throttleKey());
    
            throw ValidationException::withMessages([
                'user_email' => trans('auth.failed'),
            ]);
        }
    
        // Log the user in with the 'masteradmins' guard
        Auth::guard('masteradmins')->login($user, $this->boolean('user_remember'));
    
        // Also log the user in with the second guard, for example 'secondguard'
        Auth::guard('masteradmins')->setUser($user);
    
        if ($this->boolean('user_remember')) {
            Cookie::queue(Cookie::make('user_email', $this->input('user_email'), 60 * 24 * 30)); // 30 days
            Cookie::queue(Cookie::make('user_password', $this->input('user_password'), 60 * 24 * 30)); // 30 days
            Cookie::queue(Cookie::make('user_remember', $this->boolean('user_remember'), 60 * 24 * 30));
        } else {
            Cookie::queue(Cookie::forget('user_email'));
            Cookie::queue(Cookie::forget('user_password'));
            Cookie::queue(Cookie::forget('user_remember'));
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
            'user_email' => trans('auth.throttle', [ // changed to 'user_email'
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
        return Str::transliterate(Str::lower($this->string('user_email')).'|'.$this->ip()); // changed to 'user_email'
    }
}
