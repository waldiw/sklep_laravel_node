<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Post implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // [0-9]{2}-[0-9]{3}  Kod pocztowy ^([_0-9]{2})-([_0-9]{3})$
        $temp = preg_match('#^([_0-9]{2})-([_0-9]{3}).*$#', $value);
        if($temp == 0) {
            $fail('Pole :attribute musi mieć zawierać kod pocztowy i pocztę');
        }
    }
}
