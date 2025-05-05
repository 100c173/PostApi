<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class MaxKeywordCountRule implements ValidationRule
{
    protected int $max;
    protected int $actual = 0;

    public function __construct(int $max = 10)
    {
        $this->max = $max;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $words = preg_split('/[\s,]+/', trim($value));
        $this->actual = count($words);

        if ($this->actual > $this->max) {
            $fail("The :attribute must not contain more than {$this->max} keywords. You entered {$this->actual}.");
        }
    }
}
