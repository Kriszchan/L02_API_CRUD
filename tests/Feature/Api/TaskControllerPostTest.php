<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskControllerPostTest extends TestCase
{
    use RefreshDatabase;
    public function test_post_endpoint_exists()
    {
        $response = $this->postJson("/api/tasks");
        $response->assertStatus(422);
    }
    public function test_post_endpoint_creates_a_task()
    {
        $this->postJson("/api/tasks", [
            'title' => 'New Task',
            'description' => 'This is a new task description.',
        ]);

        $this->assertDatabaseHas('tasks', ['title' => 'New Task', 'description' => 'This is a new task description.']);
    }
    public function test_post_returns_successful_response()
    {
        $response = $this->postJson("/api/tasks", [
            'title' => 'New Task',
            'description' => 'This is a new task description.',
        ]);
        $response->assertStatus(201);
    }
    public function test_post_endpoint_fails_if_task_is_invalid()
    {
        $response = $this->postJson("/api/tasks", [
            'title' => '',
        ]);
        $response->assertStatus(422);
    }

}

