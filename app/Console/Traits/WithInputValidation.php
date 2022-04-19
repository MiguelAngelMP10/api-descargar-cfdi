<?php

namespace App\Console\Traits;

use Illuminate\Support\Facades\Validator;

trait WithInputValidation
{
    public function askWithValidation(string $message, array $rules = [], string $name = 'value', $default = null)
    {
        $answer = $this->ask($message, $default);

        $validator = Validator::make([
            $name => $answer,
        ], [
            $name => $rules,
        ]);

        if ($validator->passes()) {
            return $answer;
        }

        foreach ($validator->errors()->all() as $error) {
            $this->error($error);
        }

        return $this->askWithValidation($message, $rules, $name, $default);
    }

    public function secretWithValidation(string $message, array $rules = [], string $name = 'value')
    {
        $answer = $this->secret($message, false);

        $validator = Validator::make([
            $name => $answer,
        ], [
            $name => $rules,
        ]);

        if ($validator->passes()) {
            return $answer;
        }

        foreach ($validator->errors()->all() as $error) {
            $this->error($error);
        }
        $this->secretWithValidation($message, $rules, $name);
    }
}
