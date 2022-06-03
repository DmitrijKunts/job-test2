<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TokenControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_check()
    {
        $response = $this->get('/api/v1/token');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
            ]);
        $this->assertTrue($response['token'] != '');
    }
}
