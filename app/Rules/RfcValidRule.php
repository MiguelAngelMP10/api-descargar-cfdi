<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use PhpCfdi\Rfc\Exceptions\InvalidExpressionToParseException;
use PhpCfdi\Rfc\Rfc;

class RfcValidRule implements Rule
{
    /**
     * @var string
     */
    private string $message;

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     *
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        try {
            Rfc::parse($value);
        } catch (InvalidExpressionToParseException $exception) {
            $this->message = "The ${attribute} field not appears to be valid.";
            return false;
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return $this->message;
    }
}
