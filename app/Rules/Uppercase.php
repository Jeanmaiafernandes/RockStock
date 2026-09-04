<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class Uppercase implements ValidationRule
{

    protected $data = [];

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $this->data[$attribute] = $value;
    }
}
