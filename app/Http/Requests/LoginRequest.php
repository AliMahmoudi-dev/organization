<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'national_code' => ['required', 'digits:10', 'exists:users,national_code'],
            'password' => ['required'],
            'remember' => ['required', 'boolean'],
        ];
    }

    public function messages()
    {
        return [
            'national_code.exists' => 'کاربری با این کد ملی در سیستم ثبت نشده است.',
        ];
    }

    public function authenticate()
    {
        $this->ensureIsNotRateLimited();

        $credentials = $this->only(['national_code', 'password']);

        if (!Auth::attempt($credentials, $this->remember)) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'password' => __('auth.password'),
            ]);
        };

        RateLimiter::clear($this->throttleKey());

        $this->session()->regenerate();
    }

    public function ensureIsNotRateLimited()
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        };

        throw ValidationException::withMessages([
            'throttle' => __('auth.throttle', [
                'seconds' => RateLimiter::availableIn($this->throttleKey()),
            ]),
        ]);
    }

    public function throttleKey()
    {
        return Str::transliterate(strtolower($this->ip() . '|' . $this->national_code));
    }

    public function prepareForValidation()
    {
        $this->merge(['remember' => $this->exists('remember')]);
    }
}
