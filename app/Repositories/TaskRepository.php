<?php

namespace App\Repositories;

use App\Data\Admin\Task\TaskAssignData;
use App\Models\Task;
use App\Repositories\Contracts\TaskRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class TaskRepository extends AbstractRepository implements TaskRepositoryInterface
{
    public function __construct(Task $task)
    {
        parent::__construct($task);
    }

    public function assign(TaskAssignData $data): bool
    {
        $task = Task::find($data->id);
        $task->assigned_user_id = Auth::user()->id ?? null;

        return $task->save();
    }
}
