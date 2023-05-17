<?php

namespace Tests\Feature\Commands;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SyncSatCatalogsTest extends TestCase
{
    use RefreshDatabase;

    private string $response_tags = 'tests/_files/resources-sat-catalogs/tags.json';

    private function addResponseFake()
    {
        Http::fake([
            'api.github.com/repos/phpcfdi/resources-sat-catalogs/tags' => Http::response(file_get_contents($this->response_tags)),
            'api.github.com/repos/phpcfdi/resources-sat-catalogs/zipball/refs/tags/v5.5.20220419' => Http::response(
                file_get_contents('tests/_files/resources-sat-catalogs/phpcfdi-resources-sat-catalogs-fake.zip')
            ),
        ]);
    }

    public function test_equals_version_tag()
    {
        $this->addResponseFake();
        $response = Http::get('api.github.com/repos/phpcfdi/resources-sat-catalogs/tags')->json();
        $this->assertEquals('v5.5.20220419', $response[0]['name']);
    }

    public function test_download_zip_and_exists_zip()
    {
        $this->addResponseFake();
        Storage::fake('local');
        $response = Http::get(
            'api.github.com/repos/phpcfdi/resources-sat-catalogs/zipball/refs/tags/v5.5.20220419'
        )->body();
        Storage::put('v5.5.20220419.zip', $response);
        $this->assertTrue(Storage::exists('v5.5.20220419.zip'));
    }
}
