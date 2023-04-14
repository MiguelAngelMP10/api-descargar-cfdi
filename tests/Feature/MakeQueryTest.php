<?php

namespace Tests\Feature;

use Faker\Provider\Uuid;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PhpCfdi\Rfc\RfcFaker;
use Tests\TestCase;

class MakeQueryTest extends TestCase
{
    use WithValidFielTrait, RefreshDatabase;


    public function test_it_refuse_an_invalid_empty_request(): void
    {
        $this->sanctumAuthenticate();
        $this->setUpValidFiel();
        $response = $this->post('/api/v1/make-query', []);
        $response->assertStatus(422)->assertJson([
            'message' => 'Invalid data',
            'errors' => [
                'cer' => ['The cer field is required.'],
                'key' => ['The key field is required.'],
                'password' => ['The password field is required.'],
            ],
        ]);
    }

    public function test_it_refuse_sending_any_value_in_fields_downloadType_and_requestType(): void
    {
        $this->sanctumAuthenticate();
        $this->setUpValidFiel();
        $response = $this->post(
            '/api/v1/make-query',
            [
                'cer' => $this->getCertificate(),
                'key' => $this->getKey(),
                'password' => $this->getFielPassword(),
                "period" => [
                    "start" => "2021-11-01 00:00:01",
                    "end" => "2021-12-31 23:59:59"
                ],
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
        $this->setUpValidFiel();
        $response = $this->post(
            '/api/v1/make-query',
            [
                'cer' => $this->getCertificate(),
                'key' => $this->getKey(),
                'password' => $this->getFielPassword(),
                "period" => [
                    "start" => "2021-11-01 00:00:01",
                    "end" => "2021-12-31 23:59:59"
                ],
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
        $this->setUpValidFiel();
        $response = $this->post(
            '/api/v1/make-query',
            [
                'cer' => $this->getCertificate(),
                'key' => $this->getKey(),
                'password' => $this->getFielPassword(),
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
                'documentType' => ["The documentType must be one of the following types: I, E, T, N, P"]
            ]
        ]);
    }

    public function test_validate_add_complemento_cfdi()
    {
        $this->sanctumAuthenticate();
        $this->setUpValidFiel();
        $response = $this->post(
            '/api/v1/make-query',
            [
                'cer' => $this->getCertificate(),
                'key' => $this->getKey(),
                'password' => $this->getFielPassword(),
                "period" => [
                    "start" => "2021-11-01 00:00:01",
                    "end" => "2021-11-01 23:59:59"
                ],
                "complementoCfdi" => "algo"
            ]
        );
        $response->assertStatus(422)->assertJson([
            'message' => "PhpCfdi\\SatWsDescargaMasiva\\Shared\\ComplementoCfdi value algo was not found"
        ]);
    }

    public function test_validate_add_document_status()
    {
        $this->sanctumAuthenticate();
        $this->setUpValidFiel();
        $response = $this->post(
            '/api/v1/make-query',
            [
                'cer' => $this->getCertificate(),
                'key' => $this->getKey(),
                'password' => $this->getFielPassword(),
                "period" => [
                    "start" => "2021-11-01 00:00:01",
                    "end" => "2021-11-01 23:59:59"
                ],
                "documentStatus" => "otra cosa"
            ]
        );

        $response->assertStatus(422)->assertJson([
            'message' => 'Invalid data',
            'errors' => [
                'documentStatus' => ["The selected document status is invalid."]
            ]
        ]);
    }

    public function test_validate_add_uuid()
    {
        $this->sanctumAuthenticate();
        $this->setUpValidFiel();
        $response = $this->post(
            '/api/v1/make-query',
            [
                'cer' => $this->getCertificate(),
                'key' => $this->getKey(),
                'password' => $this->getFielPassword(),
                "period" => [
                    "start" => "2021-11-01 00:00:01",
                    "end" => "2021-11-01 23:59:59"
                ],
                "uuid" => ''
            ]
        );

        $response->assertStatus(422)->assertJson([
            'message' => 'Invalid data',
            'errors' => [
                'uuid' => ["The uuid must be a valid UUID."]
            ]
        ]);
    }

    public function test_validate_add_rfcOnBehalf()
    {
        $this->sanctumAuthenticate();
        $this->setUpValidFiel();
        $response = $this->post(
            '/api/v1/make-query',
            [
                'cer' => $this->getCertificate(),
                'key' => $this->getKey(),
                'password' => $this->getFielPassword(),
                "period" => [
                    "start" => "2021-11-01 00:00:01",
                    "end" => "2021-11-01 23:59:59"
                ],
                "rfcOnBehalf" => (new RfcFaker)->mexicanRfc() . '-',
            ]
        );

        $response->assertStatus(422)->assertJson([
            'message' => 'Invalid data',
            'errors' => [
                'rfcOnBehalf' => ["The rfcOnBehalf field not appears to be valid."]
            ]
        ]);
    }

    public function test_validate_add_endpoint(){
        $this->sanctumAuthenticate();
        $this->setUpValidFiel();
        $response = $this->post(
            '/api/v1/make-query',
            [
                'cer' => $this->getCertificate(),
                'key' => $this->getKey(),
                'password' => $this->getFielPassword(),
                "period" => [
                    "start" => "2021-11-01 00:00:01",
                    "end" => "2021-11-01 23:59:59"
                ],
               'endPoint' => 'algo'
            ]
        );

        $response->assertStatus(422)->assertJson([
            'message' => 'Invalid data',
            'errors' => [
                'endPoint' => ["The endPoint must be one of the following types: cfdi, retenciones"]
            ]
        ]);
    }

}
