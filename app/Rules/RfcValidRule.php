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
    private $message;

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     *
     * @return bool
     */
    public function passes($attribute, $value)
    {
        try {
            Rfc::parse($value);
        } catch (InvalidExpressionToParseException $exception) {
            $this->message = 'The rfc field not appears to be valid.';
            return false;
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->message;
    }
}
