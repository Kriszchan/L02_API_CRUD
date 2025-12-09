<?php

namespace Tests\Feature\Api;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskControllerDeleteTest extends TestCase
{
    use RefreshDatabase;
    public function test_delete_endpoint_exists()
    {
        $task = Task::factory()->create();
        $response = $this->deleteJson("/api/tasks/{$task->id}");
        $response->assertStatus(204);
    }
    public function test_delete_endpoint_deletes_a_task()
    {
        $task = Task::factory()->create();
        $response = $this->deleteJson("/api/tasks/{$task->id}");
        $response->assertNoContent();

        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }
    public function test_delete_returns_succesfull_response()
    {
        $task = Task::factory()->create();
        $response = $this->deleteJson("/api/tasks/{$task->id}");
        $response->assertStatus(204);
    }
    public function test_delete_endpoint_fails_if_task_does_not_exist()
    {
        $response = $this->deleteJson("/api/tasks/{111111111111}");
        $response->assertStatus(404);
    }
    public function test_delete_endpoint_deletes_the_correct_task()
    {
        $task1 = Task::factory()->create();
        $task2 = Task::factory()->create();

        $response = $this->deleteJson("/api/tasks/{$task1->id}");
        $response->assertNoContent();

        $this->assertDatabaseMissing('tasks', ['id' => $task1->id]);
        $this->assertDatabaseHas('tasks', ['id' => $task2->id]);
    }
    public function test_delete_endpoint_fails_if_no_params_given()
    {

        $response1 = $this->deleteJson("/api/tasks");
        $response1->assertStatus(405);

    }

}
