<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeleteTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function deleteTest(): void
    {
        $response = $this->delete('/api/tasks/1');

        $response->assertStatus(200);
    }
}
