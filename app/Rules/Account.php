<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Account implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $temp = preg_match('#^\\d{26}+$#', $value); // sprawdzamy czy same cyfry i długość 26 znaków
        //dd($temp);
        if($temp == 0) {
            $fail('Pole :attribute musi zawierać 26 cyfr bez spacji');
        }
    }
}
