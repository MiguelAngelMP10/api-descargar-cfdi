<?php

namespace App\Http\Requests;

use App\Rules\RfcValidRule;
use App\Utils\ComplementoCfdiList;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreQueryRequest extends FormRequest
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
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'period_start' => 'date',
            'period_end' => 'date',
            'endPoint' => ['array', 'nullable', Rule::in(['cfdi', 'retenciones'])],
            'downloadType' => [
                'array', Rule::in(['issued', 'received']),
            ],
            'requestType' => [
                'array', Rule::in(['xml', 'metadata']),
            ],
            'rfcMatches' => 'array',
            'documentType' => [
                'nullable', 'string', Rule::in(['I', 'E', 'T', 'N', 'P']),
            ],
            'complementoCfdi' => ['string', 'nullable',
                Rule::in(array_keys(ComplementoCfdiList::COMPLEMENTOS_CFDI_LIST)),
            ],
            'documentStatus' => [
                'nullable', Rule::in(['active', 'cancelled']),
            ],
            'uuid' => ['nullable', 'uuid'],
            'rfcOnBehalf' => ['nullable', 'string', new RfcValidRule()],
            'rfcMatches.*' => ['nullable', 'string', new RfcValidRule()],
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
            'complementoCfdi,in' => 'The complementoCfdi must be one of the following types: :values',
            'endPoint.in' => 'The endPoint must be one of the following types: :values',
            'documentStatus.string' => 'The documentStatus must be a string.',
            'documentStatus.in' => 'The documentStatus must be one of the following types: :values',
            'rfcMatches.array' => 'The rfcMatches must be an array.',
        ];
    }
}
