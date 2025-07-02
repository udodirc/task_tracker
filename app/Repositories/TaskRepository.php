<?php

namespace App\Repositories;

use App\Models\Menu;
use App\Models\Task;
use App\Repositories\Contracts\MenuRepositoryInterface;
use App\Repositories\Contracts\TaskRepositoryInterface;

class TaskRepository extends AbstractRepository implements TaskRepositoryInterface
{
    public function __construct(Task $task)
    {
        parent::__construct($task);
    }
}
