<?php

namespace Tests\Unit;

use App\Data\Admin\Task\TaskCreateData;
use App\Data\Admin\Task\TaskUpdateData;
use App\Enums\PermissionsEnum;
use App\Models\Task;
use App\Repositories\TaskRepository;
use App\Services\TaskService;
use Illuminate\Database\Eloquent\Collection;

class TaskTest extends BaseTest
{
    protected function getServiceClass(): string
    {
        return TaskService::class;
    }

    protected function getRepositoryClass(): string
    {
        return TaskRepository::class;
    }

    public function testCreateTask(): void
    {
        $dto = new TaskCreateData(
            title: 'title',
            description: 'description'
        );

        $task = new Task([
            'title' => 'title',
            'description' => 'description'
        ]);

        $this->assertCreateEntity(
            createDto: $dto,
            expectedInput: [
                'title' => 'title',
                'description' => 'description'
            ],
            expectedModel: $task
        );
    }

    public function testUpdateUser(): void
    {
        $dto = new TaskUpdateData(
            title: 'Updated title',
            description: 'Updated description'
        );

        $task = new Task([
            'id' => 1,
            'title' => 'title',
            'description' => 'description'
        ]);

        $task->title = 'Updated title';
        $task->description = 'Updated description';

        $this->assertUpdateEntity(
            model: $task,
            updateDto: $dto,
            expectedInput: [
                'title' => 'Updated title',
                'description' => 'Updated description'
            ],
            expectedModel: $task
        );
    }

    public function testDeleteTask(): void
    {
        $task = new Task([
            'id' => 1,
            'title' => 'title',
            'description' => 'description'
        ]);

        $this->assertDeleteEntity(
            model: $task
        );
    }

    public function testListUsers(): void
    {
        $tasks = new Collection([
            new Task([
                'id' => 1,
                'title' => 'title',
                'description' => 'description'
            ]),
            new Task([
                'id' => 2,
                'title' => 'title2',
                'description' => 'description2'
            ]),
        ]);

        $this->assertListItemsEntity(
            model: $tasks,
            items: ['title', 'title2'],
            field: 'title'
        );
    }

    public function testShowTask(): void
    {
        $this->assertShowItemEntity(
            PermissionsEnum::UserView->value,
            'task.show',
            [
                'title' => 'title',
                'description' => 'description'
            ]
        );
    }
}
