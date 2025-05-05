<?php

namespace App\Rules;

use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class FutureDateRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        try {
            $date = Carbon::parse($value);
            if (!$date->isFuture()) {
                $fail('The :attribute must be a future date.');
            }
        } catch (\Exception $e) {
            $fail('The :attribute must be a valid date.');
        }
    }
}
