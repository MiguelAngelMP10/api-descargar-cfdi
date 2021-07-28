<?php

namespace Tests\Feature\Http\Controllers\api\v1;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SendCerKeyControllerTest extends TestCase
{

    public function testSendCerKey()
    {
        $response = $this->post('/api/v1/send-cer-key');

        $response->dump();

        $response->assertStatus(200);
    }
}