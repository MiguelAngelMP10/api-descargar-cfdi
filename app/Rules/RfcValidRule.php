<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;
use PhpCfdi\Rfc\Exceptions\InvalidExpressionToParseException;
use PhpCfdi\Rfc\Rfc;

class RfcValidRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  Closure(string): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        try {
            Rfc::parse($value);
        } catch (InvalidExpressionToParseException $exception) {
            $fail("The {$attribute} field not appears to be valid.");
        }
    }
}
