<?php

namespace Tests\Feature;

use Faker\Factory;
use Faker\Provider\Uuid;
use GuzzleHttp\Psr7\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpClient\HttpClient;
use Tests\TestCase;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Request;

class VerifyQueryTest extends TestCase
{
    use WithValidFielTrait, RefreshDatabase;

    public function test_it_refuse_an_invalid_empty_request(): void
    {
        $this->setUpValidFiel();
        $this->sanctumAuthenticate();
        $response = $this->post('/api/v1/verify-query', []);

        $response->assertStatus(422)->assertJson([
            'message' => 'Invalid data',
            'errors' => [
                'RFC' => ['The RFC field is required.'],
                'password' => ['The password field is required.'],
                'retenciones' => ['The retenciones field is required.'],
                'requestId' => ['The requestId field is required.'],
            ],
        ]);
    }

    public function test_validate_rfc()
    {
        $this->sanctumAuthenticate();
        $this->setUpValidFiel();
        $response = $this->post(
            '/api/v1/verify-query',
            [
                'RFC' => 'a',
                'password' => '12345678a',
                "retenciones" => false,
                'requestId' => "",
            ]
        );

        $response->assertStatus(422)->assertJson([
            'message' => 'Invalid data',
            'errors' => [
                'RFC' => ["The RFC field not appears to be valid."]
            ]
        ]);
    }

    public function test_validate_password()
    {
        $this->sanctumAuthenticate();
        $this->setUpValidFiel();
        $response = $this->post(
            '/api/v1/verify-query',
            [
                'RFC' => 'esto-no-es-un-rfc',
                'password' => 1123456789,
                "retenciones" => false,
                'requestId' => "",
            ]
        );

        $response->assertStatus(422)->assertJson([
            'message' => 'Invalid data',
            'errors' => [
                'password' => ["The password field no is string."]
            ]
        ]);
    }

    public function test_validate_retenciones()
    {
        $this->sanctumAuthenticate();
        $this->setUpValidFiel();
        $response = $this->post(
            '/api/v1/verify-query',
            [
                'RFC' => 'esto-no-es-un-rfc',
                'password' => 1123456789,
                "retenciones" => "otra-cosa",
                'requestId' => "",
            ]
        );

        $response->assertStatus(422)->assertJson([
            'message' => 'Invalid data',
            'errors' => [
                'retenciones' => ["The retenciones field must be true or false."]
            ]
        ]);
    }

    public function test_validate_requestid()
    {
        $this->sanctumAuthenticate();
        $this->setUpValidFiel();
        $response = $this->post(
            '/api/v1/verify-query',
            [
                'RFC' => 'esto-no-es-un-rfc',
                'password' => 1123456789,
                "retenciones" => "otra-cosa",
                'requestId' => "otra-cosa",
            ]
        );

        $response->assertStatus(422)->assertJson([
            'message' => 'Invalid data',
            'errors' => [
                'requestId' => ["The requestId must be a valid UUID."]
            ]
        ]);
    }

    public function test_certificado_invalido()
    {
        $this->sanctumAuthenticate();
        $this->setUpValidFiel();

        $response = $this->post(
            '/api/v1/verify-query',
            [
                'RFC' => 'EKU9003173C9',
                'password' => "12345678a",
                "retenciones" => false,
                'requestId' => Uuid::uuid(),
            ]
        );

        $response->assertStatus(200)->assertJson([
            'status' => [
                'code' => 305,
                'message' => 'Certificado Inválido'
            ],
            'codeRequest' => [
                'value' => 0,
                'message' => 'Desconocida'
            ],
            'statusRequest' => [
                'value' => 0,
                'message' => 'Desconocida'
            ],
            'numberCfdis' => 0,
            'packagesIds' => []
        ]);

        Http::fake([
            'https://reqres.in/api/users' =>
                function (Request $request) {
                    if ($request->method() == 'GET') {
                        return Http::response([
                            'get' => 'ok',
                        ], 200, ['Headers']);
                    }
                    if ($request->method() == 'POST') {
                        return Http::response([
                            'post' => 'ok',
                        ], 200, ['Headers']);
                    }
                },

        ]);
    }
}
