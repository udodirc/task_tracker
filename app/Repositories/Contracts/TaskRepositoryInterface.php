<?php

namespace App\Repositories\Contracts;

use App\Data\Admin\Task\TaskAssignData;
use App\Data\Admin\Task\TaskChangeStatusData;
use App\Models\Task;

interface TaskRepositoryInterface extends BaseRepositoryInterface
{
    public function assign(TaskAssignData $data): bool;

    public function changeStatus(Task $task, TaskChangeStatusData $data): bool;
}
