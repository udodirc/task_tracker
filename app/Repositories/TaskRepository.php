<?php

namespace App\Repositories;

use App\Data\Admin\Task\TaskAssignData;
use App\Data\Admin\Task\TaskChangeStatusData;
use App\Models\Task;
use App\Repositories\Contracts\TaskRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TaskRepository extends AbstractRepository implements TaskRepositoryInterface
{
    public function __construct(Task $task)
    {
        parent::__construct($task);
    }

    public function all(): Collection
    {
        return Task::where('created_by_user_id', Auth::id())
            ->orWhere('assigned_user_id', Auth::id())
            ->get();
    }

    public function assign(TaskAssignData $data): bool
    {
        $task = Task::find($data->id);
        $task->assigned_user_id = Auth::id() ?? null;

        return $task->save();
    }

    public function changeStatus(Task $task, TaskChangeStatusData $data): bool
    {
        $task->status = $data->status;

        return $task->save();
    }
}
