<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Validation rules
     */
    public function rules(): array
    {
        return [
            'email'    => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Kurdish validation messages (required / email)
     */
    public function messages(): array
    {
        return [
            'email.required'    => 'تکایە ئیمەیڵ بنووسە',
            'email.email'       => 'ئیمەیڵەکە دروست نیە',
            'password.required' => 'تکایە تێپەڕەوشە بنووسە',
        ];
    }

    /**
     * Authenticate user
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        if (! Auth::attempt($this->only('email', 'password'), $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => 'ئیمەیڵ یان تێپەڕەوشە هەڵەیە',
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Rate limit message (Kurdish)
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => "زۆر هەوڵت داوە، تکایە دوای {$seconds} چرکە هەوڵ بدەوە",
        ]);
    }

    /**
     * Throttle key
     */
    public function throttleKey(): string
    {
        return Str::transliterate(
            Str::lower($this->string('email')).'|'.$this->ip()
        );
    }
}
