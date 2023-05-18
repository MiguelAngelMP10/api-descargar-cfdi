<?php

namespace Tests\Feature;

use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CfdiToJsonTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_refuse_an_invalid_empty_request(): void
    {
        $this->sanctumAuthenticate();
        $response = $this->post('/api/v1/cfdi-to-json');
        $response->assertStatus(422)->assertJson([
            'message' => 'Invalid data',
            'errors' => [
                'cfdis' => ['The cfdis field is required.'],
            ],
        ]);
    }

    public function test_it_array_files_of_cfdis_invalid()
    {
        $this->sanctumAuthenticate();
        $response = $this->post('/api/v1/cfdi-to-json',
            ['cfdis' => [
                UploadedFile::fake()->create('fake1.text'),
                UploadedFile::fake()->create('fake2.text')
            ]]);
        $response->assertStatus(422)->assertJson([
            'message' => 'Invalid data',
            'errors' => [
                'cfdis.0' => ['The cfdis.0 must be a file of type: application/xml, text/xml.'],
                'cfdis.1' => ['The cfdis.1 must be a file of type: application/xml, text/xml.'],
            ],
        ]);
    }

    public function test_xml_full_success_is_array()
    {
        $this->sanctumAuthenticate();
        $cfdi1 = __DIR__ . '/../_files/cfdis/cfdi-example.xml';
        $cfdi2 = __DIR__ . '/../_files/cfdis/detallista-example.xml';

        $this->post('/api/v1/cfdi-to-json',
            [
                'cfdis' => [
                    UploadedFile::fake()->createWithContent('cfdi-example.xml', file_get_contents($cfdi1)),
                    UploadedFile::fake()->createWithContent('detallista-example.xml', file_get_contents($cfdi2))
                ]
            ])
            ->assertStatus(200)
            ->assertJsonIsArray();
    }

    public function test_xml_full_success_is_object()
    {
        $this->sanctumAuthenticate();
        $cfdi1 = __DIR__ . '/../_files/cfdis/cfdi-example.xml';

        $this->post('/api/v1/cfdi-to-json',
            [
                'cfdis' => [
                    UploadedFile::fake()->createWithContent('cfdi-example.xml', file_get_contents($cfdi1))]
            ])
            ->assertStatus(200)
            ->assertJsonIsObject();
    }

    public function test_xml_validate_content_response_object()
    {
        $this->sanctumAuthenticate();
        $cfdi1 = __DIR__ . '/../_files/cfdis/cfdi-example.xml';

        $this->post('/api/v1/cfdi-to-json',
            [
                'cfdis' => [
                    UploadedFile::fake()->createWithContent('cfdi-example.xml', file_get_contents($cfdi1))]
            ])
            ->assertStatus(200)
            ->assertJsonIsObject()
            ->assertJsonPath('Complemento.0.TimbreFiscalDigital.UUID', "CEE4BE01-ADFA-4DEB-8421-ADD60F0BEDAC")
            ->assertJsonPath('NoCertificado', "00001000000401220451");
    }

    public function test_xml_object_check_json_structure()
    {
        $this->sanctumAuthenticate();
        $cfdi1 = __DIR__ . '/../_files/cfdis/cfdi-example.xml';

        $this->post('/api/v1/cfdi-to-json',
            [
                'cfdis' => [
                    UploadedFile::fake()->createWithContent('cfdi-example.xml', file_get_contents($cfdi1))]
            ])
            ->assertStatus(200)
            ->assertJsonIsObject()
            ->assertJsonStructure([
                'Certificado',
                'Fecha',
                'FormaPago',
                'LugarExpedicion',
                'MetodoPago',
                'Moneda',
                'NoCertificado',
                'Sello',
                'Serie',
                'Emisor' => [
                    'Nombre',
                    'RegimenFiscal',
                    'Rfc',
                ],
                'Receptor' => [
                    'Nombre',
                    'Rfc',
                    'UsoCFDI',
                ]
            ]);
    }

    public function test_xml_validate_content_response_array_json_structure()
    {
        $this->sanctumAuthenticate();
        $cfdi1 = __DIR__ . '/../_files/cfdis/cfdi-example.xml';
        $cfdi2 = __DIR__ . '/../_files/cfdis/detallista-example.xml';

        $this->post('/api/v1/cfdi-to-json',
            [
                'cfdis' => [
                    UploadedFile::fake()->createWithContent('cfdi-example.xml', file_get_contents($cfdi1)),
                    UploadedFile::fake()->createWithContent('detallista-example.xml', file_get_contents($cfdi2))
                ]
            ])
            ->assertStatus(200)
            ->assertJsonIsArray()
            ->assertJsonStructure([
                '*' => [
                    'Certificado',
                    'Fecha',
                    'FormaPago',
                    'LugarExpedicion',
                    'MetodoPago',
                    'Moneda',
                    'NoCertificado',
                    'Sello',
                    'Serie',
                    'Emisor',
                    'Receptor',
                ]
            ]);
    }
}

