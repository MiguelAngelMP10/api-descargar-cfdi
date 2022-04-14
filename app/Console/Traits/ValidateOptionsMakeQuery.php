<?php

namespace App\Console\Traits;

use App\Rules\RfcValidRule;
use App\Utils\ComplementoCfdiList;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

trait ValidateOptionsMakeQuery
{
    protected array $data;
    protected int $exitCode = 0;

    protected function validateOptions()
    {
        $this->getData();
        $validator = Validator::make(
            $this->data,
            $this->getRules(),
            $this->getMessageCustom()
        );

        if ($validator->passes()) {
            $this->exitCode = 0;
        } else {
            $this->exitCode = 1;
            $this->alert('ERRORS');
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }
        }
    }

    protected function getData(): void
    {
        $this->data = [
            'password' => $this->option('password'),
            'endPoint' => $this->option('endPoint'),
            'periodStar' => $this->option('periodStar'),
            'periodEnd' => $this->option('periodEnd'),
            'requestType' => $this->option('requestType'),
            'downloadType' => $this->option('downloadType'),
            'documentType' => $this->option('documentType'),
            'complementCfdi' => $this->option('complementCfdi'),
            'documentStatus' => $this->option('documentStatus'),
            'uuid' => $this->option('uuid'),
            'rfcOnBehalf' => $this->option('rfcOnBehalf'),
            'rfcMatch' => $this->option('rfcMatch'),
        ];
    }

    protected function getRules(): array
    {
        return [
            'password' => ['required', 'min:5'],
            'endPoint' => ['required', Rule::in(['cfdi', 'retenciones'])],
            'periodStar' => ['nullable', 'date', 'date_format:Y-m-d H:i:s'],
            'periodEnd' => ['nullable', 'date', 'date_format:Y-m-d H:i:s'],
            'requestType' => ['required', Rule::in(['xml', 'metadata'])],
            'downloadType' => ['required', Rule::in(['issued', 'received'])],
            'documentType' => ['required', Rule::in(['I', 'E', 'T', 'N', 'P', 'U'])],
            'complementCfdi' => ['nullable', Rule::in(array_keys(ComplementoCfdiList::COMPLEMENTOS_CFDI_LIST))],
            'documentStatus' => [Rule::in(['undefined', 'active', 'cancelled'])],
            'uuid' => ['nullable', 'uuid'],
            'rfcOnBehalf' => ['bail', 'nullable', new RfcValidRule()],
            'rfcMatch.*' => [new RfcValidRule()],
        ];
    }

    protected function getMessageCustom(): array
    {
        return [
            'requestType.in' => 'The requestType must be one of the following types: :values.',
            'downloadType.in' => 'The downloadType must be one of the following types: :values.',
            'documentType.in' => 'The documentType must be one of the following types: :values.',
            'complementCfdi.in' => 'The complementCfdi must be one of the following types: :values.',
            'documentStatus.in' => 'The documentStatus must be one of the following types: :values.',
            'endPoint.in' => 'The endPoint must be one of the following types: :values.',
        ];
    }
}
