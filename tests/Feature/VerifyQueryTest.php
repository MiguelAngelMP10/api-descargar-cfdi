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
                'cer' => ['The cer field is required.'],
                'key' => ['The key field is required.'],
                'password' => ['The password field is required.'],
                'requestId' => ['The requestId field is required.'],
            ],
        ]);
    }

    public function test_validate_cer_required()
    {
        $this->sanctumAuthenticate();
        $this->setUpValidFiel();
        $response = $this->post(
            '/api/v1/verify-query',
            [
                'cer' => null,
                'key' => $this->getKey(),
                'password' => $this->getFielPassword(),
                'requestId' => Uuid::uuid(),
            ]
        );

        $response->assertStatus(422)->assertJson([
            'message' => 'Invalid data',
            'errors' => [
                'cer' => ["The cer field is required."]
            ]
        ]);
    }

    public function test_validate_cer_string()
    {
        $this->sanctumAuthenticate();
        $this->setUpValidFiel();
        $response = $this->post(
            '/api/v1/verify-query',
            [
                'cer' => 112,
                'key' => $this->getKey(),
                'password' => $this->getFielPassword(),
                'requestId' => Uuid::uuid(),
            ]
        );

        $response->assertStatus(422)->assertJson([
            'message' => 'Invalid data',
            'errors' => [
                'cer' => ["The cer must be a string."]
            ]
        ]);
    }

    public function test_validate_key_required()
    {
        $this->sanctumAuthenticate();
        $this->setUpValidFiel();
        $response = $this->post(
            '/api/v1/verify-query',
            [
                'cer' => $this->getCertificate(),
                'key' => null,
                'password' => $this->getFielPassword(),
                'requestId' => Uuid::uuid(),
            ]
        );

        $response->assertStatus(422)->assertJson([
            'message' => 'Invalid data',
            'errors' => [
                'key' => ["The key field is required."]
            ]
        ]);
    }

    public function test_validate_key_string()
    {
        $this->sanctumAuthenticate();
        $this->setUpValidFiel();
        $response = $this->post(
            '/api/v1/verify-query',
            [
                'cer' => $this->getCertificate(),
                'key' => 123,
                'password' => $this->getFielPassword(),
                'requestId' => Uuid::uuid(),
            ]
        );

        $response->assertStatus(422)->assertJson([
            'message' => 'Invalid data',
            'errors' => [
                'key' => ["The key must be a string."]
            ]
        ]);
    }

    public function test_validate_password_required()
    {
        $this->sanctumAuthenticate();
        $this->setUpValidFiel();
        $response = $this->post(
            '/api/v1/verify-query',
            [
                'cer' => $this->getCertificate(),
                'key' => $this->getKey(),
                'password' => null,
                'requestId' => Uuid::uuid(),
            ]
        );
        $response->assertStatus(422)->assertJson([
            'message' => 'Invalid data',
            'errors' => [
                'password' => ["The password field is required."]
            ]
        ]);
    }

    public function test_validate_password_string()
    {
        $this->sanctumAuthenticate();
        $this->setUpValidFiel();
        $response = $this->post(
            '/api/v1/verify-query',
            [
                'cer' => $this->getCertificate(),
                'key' => $this->getKey(),
                'password' => 123,
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

    public function test_validate_requestid_required()
    {
        $this->sanctumAuthenticate();
        $this->setUpValidFiel();
        $response = $this->post(
            '/api/v1/verify-query',
            [
                'cer' => $this->getCertificate(),
                'key' => $this->getKey(),
                'password' => $this->getFielPassword(),
                'requestId' => null,
            ]
        );

        $response->assertStatus(422)->assertJson([
            'message' => 'Invalid data',
            'errors' => [
                'requestId' => ["The requestId field is required."]
            ]
        ]);
    }

    public function test_validate_requestid_uuid()
    {
        $this->sanctumAuthenticate();
        $this->setUpValidFiel();
        $response = $this->post(
            '/api/v1/verify-query',
            [
                'cer' => $this->getCertificate(),
                'key' => $this->getKey(),
                'password' => $this->getFielPassword(),
                'requestId' => '---------',
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
                'cer' => $this->getCertificate(),
                'key' => $this->getKey(),
                'password' => $this->getFielPassword(),
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
    }
}
