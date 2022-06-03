<?php

namespace Tests\Feature\Http\Controllers\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PositionControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_get()
    {
        $this->get('/api/v1/positions')
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
            ])
            ->assertJsonPath('positions.1.name', 'Designer');
    }
}
