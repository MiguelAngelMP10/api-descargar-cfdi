<?php

namespace App\Console\Traits;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

trait ValidateOptionsVerifyQuery
{
    protected $validator;

    protected function validateData()
    {
        $this->validator = Validator::make([
            'password' => $this->option('password'),
            'endPoint' => $this->option('endPoint'),
            'requestId' => $this->option('requestId'),
        ], ['password' => ['required', 'min:5'],
            'endPoint' => ['required', Rule::in(['cfdi', 'retenciones'])],
            'requestId' => ['required', 'uuid'],
        ], [
            'requestId.required' => 'The requestId field is required.',
            'endPoint.required' => 'The endPoint field is required.',
            'endPoint.in' => 'The endPoint must be one of the following types: :values.',
            'requestId.uuid' => 'The requestId must be a valid UUID.',
        ]);
    }
}
