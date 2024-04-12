<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegistrationRequest extends FormRequest
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
        $persianAlphabetCodepoints = '\x{0621}-\x{0628}\x{062A}-\x{063A}\x{0641}-\x{0642}\x{0644}-\x{0648}\x{064E}-\x{0651}\x{0655}\x{067E}\x{0686}\x{0698}\x{06A9}\x{06AF}\x{06BE}\x{06CC}\x{0020}\x{2000}-\x{200F}\x{2028}-\x{202F}\x{0629}\x{0643}\x{0649}-\x{064B}\x{064D}\x{06D5}';

        return [
            'name' => ['required', 'string', 'max:100', 'min:3', "regex:/^[$persianAlphabetCodepoints]+$/u"],
            'national_code' => ['required', 'digits:10', 'unique:users,national_code'],
            'phone_number' => ['required', 'regex:/^(\+989)[0-9]{9}$/'],
            'email' => ['required', 'email'],
            'password' => [
                'required',
                Password::min(6)
                    ->numbers()
                    ->letters(),
            ],
            'password_confirmation' => ['required', 'same:password'],
        ];
    }

    public function prepareForValidation()
    {
        $phoen_number = !empty($this->phone_number) && !str_starts_with($this->phone_number, '+98')
            ? '+989' . substr($this->phone_number, strpos($this->phone_number, '9') + 1)
            : $this->phone_number;

        $this->merge([
            'phone_number' => $phoen_number,
        ]);
    }

    public function messages()
    {
        return [
            'phone_number.regex' => 'شماره موبایل وارد شده صحیح نمی‌باشد',
            'name.regex' => ':attribute باید حاوی حروف فارسی باشد',
        ];
    }
}
