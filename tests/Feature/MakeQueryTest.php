<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;

use Tests\TestCase;

class MakeQueryTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_refuse_an_invalid_empty_request(): void
    {
        $this->sanctumAuthenticate();

        $response = $this->post('/api/v1/make-query', []);

        $response->assertStatus(422)->assertJson([
            'message' => 'Invalid data',
            'errors' =>
                [
                    'RFC' => ['The RFC field is required.'],
                    'period.start' => ['The period.start field is required.'],
                    'period.end' => ['The period.end field is required.'],
                    'retenciones' => ['The retenciones field is required.'],
                    'downloadType' => ['The download type field is required.'],
                    'requestType' => ['The request type field is required.']
                ],
        ]);
    }

    public function test_it_refuse_sending_any_value_in_fields_downloadType_and_requestType(): void
    {
        $this->sanctumAuthenticate();
        $response = $this->post(
            '/api/v1/make-query',
            [
                'RFC' => 'EKU9003173C9',
                'password' => "12345678a",
                "period" => [
                    "start" => "2021-11-01 00:00:01",
                    "end" => "2021-12-31 23:59:59"
                ],
                "retenciones" => false,
                "downloadType" => "lo-que-sea",
                "requestType" => "lo-que-sea",
                "rfcMatch" => ""
            ]
        );

        $response->assertStatus(422)->assertJson([
            'message' => 'Invalid data',
            'errors' => [
                'downloadType' => ['The downloadType must be one of the following types: issued, received'],
                'requestType' => ['The requestType must be one of the following types: xml, metadata']
            ],
        ]);
    }

    public function test_validate_add_rfc_match_empty()
    {
        $this->sanctumAuthenticate();
        $response = $this->post(
            '/api/v1/make-query',
            [
                'RFC' => "lo-que-sea",
                'password' => "lo-que-sea",
                "period" => [
                    "start" => "2021-11-01 00:00:01",
                    "end" => "2021-12-31 23:59:59"
                ],
                "retenciones" => false,
                "downloadType" => "issued",
                "requestType" => "metadata",
                "rfcMatch" => ""
            ]
        );

        $response->assertStatus(422)->assertJson([
            'message' => 'Invalid data',
            'errors' => [
                'rfcMatch' => ['The rfc match must be an array.']
            ],
        ]);
    }

    public function test_validate_add_document_type_in()
    {
        $this->sanctumAuthenticate();
        $response = $this->post(
            '/api/v1/make-query',
            [
                'RFC' => 'EKU9003173C9',
                'password' => "12345678a",
                "period" => [
                    "start" => "2021-11-01 00:00:01",
                    "end" => "2021-11-01 23:59:59"
                ],
                "retenciones" => false,
                "downloadType" => "received",
                "requestType" => "metadata",
                "rfcMatch" => [],
                "documentType" => "ALGO-QUE-NO"
            ]
        );

        $response->assertStatus(422)->assertJson([
            'message' => 'Invalid data',
            'errors' => [
                'documentType' => ["The documentType must be one of the following types: ingreso, I, egreso, E, traslado, T, nomina, N, pago, P"]
            ]
        ]);
    }

    public function test_validate_add_complemento_cfdi()
    {
        $this->sanctumAuthenticate();
        $response = $this->post(
            '/api/v1/make-query',
            [
                'RFC' => 'EKU9003173C9',
                'password' => "12345678a",
                "period" => [
                    "start" => "2021-11-01 00:00:01",
                    "end" => "2021-11-01 23:59:59"
                ],
                "retenciones" => false,
                "downloadType" => "received",
                "requestType" => "metadata",
                "rfcMatch" => [],
                "documentType" => "E",
                "complementoCfdi" => "algo"
            ]
        );

        $response->assertStatus(422)->assertJson([
            'message' => "PhpCfdi\\SatWsDescargaMasiva\\Shared\\ComplementoCfdi value algo was not found"
        ]);
    }
}
