<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Price implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $temp = preg_match('#^\d+(?:\,\d{2})?$#', $value);
        //dd($temp);
        if($temp == 0) {
            $fail(':attribute musi mieć postać np.: 20,00');
        }
    }
}
