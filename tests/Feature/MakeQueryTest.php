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
                'requestType' => ['The requestType must be one of the following types: cfdi, metadata']
            ],
        ]);
    }

    public function test_exception_create_sat_ws_service_helper(): void
    {
        $this->sanctumAuthenticate();
        $response = $this->post(
            '/api/v1/make-query',
            [
                'RFC' => 'EKU9003kk173C9',
                'password' => "klkllkhuu",
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
            'message' => 'The RFC expression does not contain the valid parts',
        ]);
    }


}
