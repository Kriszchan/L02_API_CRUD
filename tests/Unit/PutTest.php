<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PutTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_updates_a_task_with_valid_data()
    {
        $task = Task::factory()->create();

        $payload = [
            'title' => 'Updated Task',
            'description' => 'Updated description'
        ];

        $response = $this->putJson("api/tasks/{$task->id}", $payload);

        $response->assertStatus(200);

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'title' => 'Updated Task',
            'description' => 'Updated description',
        ]);

        $response->assertJsonFragment([
            'title' => 'Updated Task',
            'description' => 'Updated description'
        ]);
    }

    public function test_it_requires_a_title()
    {
        $task = Task::factory()->create();

        $response = $this->putJson("api/tasks/{$task->id}", [
            'title' => '',
            'description' => 'Something'
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('title');
    }

    public function test_it_validates_title_max_length()
    {
        $task = Task::factory()->create();

        $response = $this->putJson("api/tasks/{$task->id}", [
            'title' => str_repeat('a', 256)
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('title');
    }

    public function test_it_allows_null_description()
    {
        $task = Task::factory()->create([
            'description' => 'Old description'
        ]);

        $payload = [
            'title' => 'New title',
            'description' => null
        ];

        $response = $this->putJson("api/tasks/{$task->id}", $payload);

        $response->assertStatus(200);

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'title' => 'New title',
            'description' => null,
        ]);
    }

    public function test_it_returns_a_task_resource()
    {
        $task = Task::factory()->create();

        $payload = [
            'title' => 'Resource Test',
            'description' => 'Testing structure'
        ];

        $response = $this->putJson("api/tasks/{$task->id}", $payload);

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'data' => [
                'id',
                'title',
                'description',
            ]
        ]);
    }
}
