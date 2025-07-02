<?php

namespace Tests\Feature;

use App\Data\Admin\Task\TaskAssignData;
use App\Models\Task;
use App\Models\User;
use App\Services\TaskService;
use Illuminate\Http\Response;

class TaskTest extends BaseTest
{
    public function testCreateTask(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $data = [
            'title' => 'Title',
            'description' => 'Description'
        ];

        $response = $this->postJson(route('task.store'), $data);

        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJsonFragment(['title' => 'Title']);
        $response->assertJsonFragment(['description' => 'Description']);
    }

    public function testUpdateTask(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $taskData = [
            'title' => 'Initial Title',
            'description' => 'Initial Description'
        ];

        $responseCreate = $this->postJson(route('task.store'), $taskData);
        $responseCreate->assertStatus(Response::HTTP_CREATED);

        $taskId = $responseCreate->json('data.id');

        $updateData = [
            'title' => 'Updated Title',
            'description' => 'Updated Description'
        ];

        $responseUpdate = $this->putJson(route('task.update', $taskId), $updateData);

        $responseUpdate->assertStatus(Response::HTTP_OK);

        $responseUpdate->assertJsonFragment(['title' => 'Updated Title']);
        $responseUpdate->assertJsonFragment(['description' => 'Updated Description']);
    }

    public function testDeleteTask(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $taskData = [
            'title' => 'Initial Title',
            'description' => 'Initial Description'
        ];

        $responseCreate = $this->postJson(route('task.store'), $taskData);
        $responseCreate->assertStatus(Response::HTTP_CREATED);

        $taskId = $responseCreate->json('data.id');

        $response = $this->deleteJson(route('task.destroy', $taskId));

        $response->assertStatus(200);
    }

    public function testTaskList(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        Task::factory()->count(3)->create([
            'created_by_user_id' => $user->id,
        ]);

        $response = $this->getJson(route('task.index'));

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonCount(3, 'data');
    }

    public function testSingleTask(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $task = Task::factory()->create([
            'created_by_user_id' => $user->id,
        ]);

        $response = $this->getJson(route('task.show', $task->id));

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonFragment(['title' => $task->title]);
        $response->assertJsonFragment(['description' => $task->description]);
    }

    public function testAssignTaskToAuthUser(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $task = Task::factory()->create([
            'assigned_user_id' => null,
        ]);

        $response = $this->getJson(route('task.show', $task->id));

        $response->assertStatus(200);
    }
}
