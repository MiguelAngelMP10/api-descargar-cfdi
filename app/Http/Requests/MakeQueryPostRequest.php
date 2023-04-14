<?php

namespace App\Http\Requests;

use App\Rules\RfcValidRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class MakeQueryPostRequest extends FormRequest
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
            'cer' => 'required|string',
            'key' => 'required|string',
            'password' => 'required|string',
            'period.start' => 'date',
            'period.end' => 'date',
            'endPoint' => [
                'nullable', Rule::in(['cfdi', 'retenciones']),
            ],
            'downloadType' => [
                'string', Rule::in(['issued', 'received']),
            ],
            'requestType' => [
                'string', Rule::in(['xml', 'metadata']),
            ],
            'rfcMatches' => 'array',
            'documentType' => [
                'string', Rule::in([ 'I', 'E', 'T', 'N', 'P']),
            ],
            'complementoCfdi' => 'string',
            'documentStatus' => [
                'string', Rule::in([ 'active', 'cancelled']),
            ],
            'uuid' => 'uuid',
            'rfcOnBehalf' => ['bail', 'string', new RfcValidRule()],
        ];
    }

    public function messages(): array
    {
        return [
            'password.required' => 'The password field is required.',
            'password.string' => 'The password field no is string.',
            'downloadType.in' => 'The downloadType must be one of the following types: :values',
            'requestType.in' => 'The requestType must be one of the following types: :values',
            'documentType.string' => 'The documentType must be a string.',
            'documentType.in' => 'The documentType must be one of the following types: :values',
            'endPoint.in' => 'The endPoint must be one of the following types: :values',
            'documentStatus.string' => 'The documentStatus must be a string.',
            'documentStatus.in' => 'The documentStatus must be one of the following types: :values',
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
