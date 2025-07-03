<?php

namespace Tests\Feature;

use App\Enums\TaskEnum;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Event;
use App\Events\TaskStatusUpdated;

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

        $response = $this->postJson(route('tasks.assign', $task->id), [
            'id' => $task->id
        ]);

        $response->assertStatus(200);

        $task->refresh(); // обновляем из БД

        $this->assertEquals($user->id, $task->assigned_user_id, 'Task was not assigned correctly');
    }

    public function testChangeStatusUpdatesTaskStatus(): void
    {
        Event::fake();

        $user = User::factory()->create();
        $this->actingAs($user);

        $task = Task::factory()->create([
            'status' => TaskEnum::New->value,
        ]);

        $status = [
            'status' => TaskEnum::InProgress->value,
        ];

        $response = $this->postJson(route('tasks.change-status', $task->id), $status);

        $response->assertStatus(200);

        $task->refresh();

        $this->assertEquals(TaskEnum::InProgress->value, $task->status);

        Event::assertDispatched(TaskStatusUpdated::class, function ($event) use ($task) {
            return $event->task->is($task);
        });
    }
}
