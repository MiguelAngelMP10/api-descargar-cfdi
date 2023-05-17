<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class DownloadPackagesRequest extends FormRequest
{
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
            'packagesIds' => ['required', 'array'],
        ];
    }

    public function messages(): array
    {
        return [
            'packagesIds.required' => 'The packagesIds field is required.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = [
            'message' => 'Petición inválida.',
            'errors' => $validator->errors(),
        ];
        throw new HttpResponseException(
            response()->json($response, 422)
        );
    }
}
