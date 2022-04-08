<?php

namespace App\Http\Requests;

use App\Rules\RfcValidRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class VerifyQueryPostRequest extends FormRequest
{
    protected $stopOnFirstFailure = false;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'RFC' => [
                'bail',
                'string',
                'required',
                new RfcValidRule(),
            ],
            'password' => 'required|string',
            'retenciones' => 'required|boolean',
            'requestId' => 'required|uuid',
        ];
    }

    public function messages(): array
    {
        return [
            'RFC.required' => 'The RFC field is required.',
            'RFC.string' => 'The RFC field no is string.',
            'password.required' => 'The password field is required.',
            'password.string' => 'The password field no is string.',
            'requestId.required' => 'The requestId field is required.',
            'requestId.uuid' => 'The requestId must be a valid UUID.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = [
            'message' => 'Invalid data',
            'errors' => $validator->errors(),
        ];
        throw new HttpResponseException(
            response()->json($response, 422)
        );
    }
}
