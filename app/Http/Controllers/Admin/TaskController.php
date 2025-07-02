<?php

namespace App\Http\Controllers\Admin;

use App\Data\Admin\Task\TaskAssignData;
use App\Data\Admin\Task\TaskCreateData;
use App\Data\Admin\Task\TaskUpdateData;
use App\Http\Controllers\BaseController;
use App\Models\Task;
use App\Resource\TaskResource;
use App\Services\TaskService;
use Illuminate\Support\Facades\Auth;

/**
 * @extends BaseController<TaskService, Task, TaskResource, TaskCreateData, TaskUpdateData>
 */
class TaskController extends BaseController
{
    public function __construct(TaskService $service)
    {
        parent::__construct(
            $service,
            TaskResource::class,
            Task::class,
            TaskCreateData::class,
            TaskUpdateData::class
        );
    }

    public function assign(TaskAssignData $data): bool
    {
        return $this->service->assign($data);
    }
}
