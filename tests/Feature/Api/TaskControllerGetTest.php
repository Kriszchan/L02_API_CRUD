<?php
namespace Tests\Feature\Api;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskControllerGetTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_endpoint_exists()
    {
        $response = $this->getJson('/api/tasks');
        $response->assertStatus(200);
    }
    public function test_index_returns_succesfull_response()
    {

        $response = $this->getJson('/api/tasks');
        $response->assertStatus(200);
    }
    public function test_index_returns_all_tasks()
    {
        Task::factory()->count(5)->create();

        $response = $this->getJson('/api/tasks');
        $response->assertJsonCount(5);
    }
    public function test_index_returns_tasks_with_expected_fields()
    {
        Task::factory()->count(3)->create();

        $response = $this->getJson('/api/tasks');
        $response->assertJsonStructure([
            '*' => ['id', 'title', 'description', 'created_at', 'updated_at']
        ]);
    }
    public function test_index_returns_empty_array_when_no_tasks()
    {
        $response = $this->getJson('/api/tasks');
        $response->assertStatus(200);
        $response->assertExactJson([]);
    }
    public function test_index_performance_with_large_number_of_tasks()
    {
        Task::factory()->count(1000)->create();

        $response = $this->getJson('/api/tasks');
        $response->assertStatus(200);
        $response->assertJsonCount(1000);
    }
}
