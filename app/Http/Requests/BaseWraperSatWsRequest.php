<?php

namespace App\Http\Requests;

use App\Helpers\SatWsService as SatWsServiceHelper;
use App\Rules\RfcValidRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Log;
use PhpCfdi\SatWsDescargaMasiva\Service as SatWsService;
use Throwable;

class BaseWraperSatWsRequest extends FormRequest
{
    private ?SatWsService $satWsService = null;

    public function getSatWsService(): SatWsService
    {
        return $this->satWsService;
    }

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
            'RFC' => ['bail', 'required', 'string', new RfcValidRule()],
            'password' => ['required', 'string'],
            'retenciones' => ['required', 'bool'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'RFC' => 'rfc',
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     *
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $errors = $validator->errors();
            if (! $errors->isEmpty()) {
                $this->failedValidation($validator);
            }
            $request = $validator->safe();
            $satWsServiceHelper = new SatWsServiceHelper();
            try {
                $service = $satWsServiceHelper->createService(
                    $request->{'RFC'},
                    $request->{'password'},
                    $request->{'retenciones'}
                );
            } catch (Throwable $exception) {
                Log::error($exception);
                $errors->add('RFC', 'Unable to create the SAT web service.');
                return;
            }
            $this->satWsService = $service;
        });
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
