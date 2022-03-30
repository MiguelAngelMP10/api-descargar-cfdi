<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class SendCerKeyRequest extends FormRequest
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
            'password' => ['required', 'string'],
            'key' => ['required', 'file', 'mimetypes:text/plain,application/octet-stream'],
            'cer' => ['required', 'file', 'mimetypes:text/plain,application/octet-stream'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'cer.mimetypes' => 'The certificate file has invalid type.',
            'key.mimetypes' => 'The private key file has invalid type.',
            'cer.file' => 'The certificate is not a file.',
            'key.file' => 'The private key is not a file.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = [
            'message' => 'Los datos enviados de certificado, llave privada o contraseña son inválidos.',
            'errors' => $validator->errors(),
        ];
        throw new HttpResponseException(
            response()->json($response, 422)
        );
    }
}
