<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class VerifyQueryPostRequest extends FormRequest
{
    protected $stopOnFirstFailure = false;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'cer' => 'required|string',
            'key' => 'required|string',
            'password' => 'required|string',
            'endPoint' => ['nullable', Rule::in(['cfdi', 'retenciones'])],
            'requestId' => 'required|uuid',
        ];
    }

    public function messages(): array
    {
        return [
            'password.required' => 'The password field is required.',
            'password.string' => 'The password field no is string.',
            'endPoint.in' => 'The endPoint must be one of the following types: :values',
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
