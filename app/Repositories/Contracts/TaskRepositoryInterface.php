<?php

namespace App\Repositories\Contracts;

use App\Data\Admin\Task\TaskAssignData;

interface TaskRepositoryInterface extends BaseRepositoryInterface
{
    public function assign(TaskAssignData $data): bool;
}
