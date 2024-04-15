<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ShebaNumber implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $drivers = config('payment.drivers');

        foreach ($drivers as $driver) {
            if (preg_match($driver['shebaPattern'], $value)) {
                return;
            };
        };

        $fail('شماره شبا وارد شده معتبر نمی‌باشد');
    }
}
