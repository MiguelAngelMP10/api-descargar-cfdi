<?php

namespace Tests\Feature\Commands;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MetadataPackageReaderTest extends TestCase
{

    public function test_path_empty_command()
    {
        $this->expectException(\RuntimeException::class);
        $this->artisan('sw:metadata:package:reader');
        $this->expectExceptionMessage('Not enough arguments (missing: "path").');
    }

}
