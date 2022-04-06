<?php

namespace App\Http\Requests;

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
            'RFC' => ['required', 'string'],
            'password' => ['required', 'string'],
            'period.start' => ['required', 'date'],
            'period.end' => ['required', 'date'],
            'retenciones' => ['required', 'boolean'],
            'downloadType' => [
                'required',
                Rule::in(['issued', 'received']),
            ],
            'requestType' => [
                'required',
                Rule::in(['xml', 'metadata']),
            ],
            'rfcMatch' => ['array'],
            'documentType' => [
                'nullable',
                Rule::in(['ingreso', 'I', 'egreso', 'E', 'traslado', 'T', 'nomina', 'N', 'pago', 'P']),
            ],
            "complementoCfdi" => ['string']

        ];
    }

    public function messages(): array
    {
        return [
            'RFC.required' => 'The RFC field is required.',
            'RFC.string' => 'The RFC field no is string.',
            'password.required' => 'The password field is required.',
            'password.string' => 'The password field no is string.',
            'downloadType.in' => 'The downloadType must be one of the following types: :values',
            'requestType.in' => 'The requestType must be one of the following types: :values',
            'documentType.in' => 'The documentType must be one of the following types: :values',
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
