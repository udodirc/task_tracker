<?php

namespace App\Services;

use App\Data\Admin\Task\TaskAssignData;
use App\Data\Admin\Task\TaskCreateData;
use App\Data\Admin\Task\TaskUpdateData;
use App\Models\Task;
use App\Repositories\Contracts\TaskRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Spatie\LaravelData\Data;

/**
 * @extends BaseService<TaskRepositoryInterface, TaskCreateData, TaskUpdateData, Task>
 */
class TaskService extends BaseService
{
    public function __construct(TaskRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }

    protected function toCreateArray(Data $data): array
    {
        /** @var TaskCreateData $data */
        return [
            'title' => $data->title,
            'description' => $data->description,
            'created_by_user_id' => Auth::user()->id ?? null,
        ];
    }

    protected function toUpdateArray(Data $data): array
    {
        /** @var TaskUpdateData $data */
        return [
            'title' => $data->title,
            'description' => $data->description
        ];
    }

    public function assign(TaskAssignData $data): bool
    {
        return $this->repository->assign($data);
    }
}
