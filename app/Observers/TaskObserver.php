<?php

namespace App\Observers;

use App\Jobs\SendTaskCreatedEmailNotificationJob;
use App\Jobs\SendTaskCreatedTelegramNotificationJob;
use App\Models\Task;

class TaskObserver
{
    /**
     * Handle the Task "created" event.
     */
    public function created(Task $task): void
    {
        SendTaskCreatedTelegramNotificationJob::dispatch($task);
        SendTaskCreatedEmailNotificationJob::dispatch($task);
    }

    /**
     * Handle the Task "updated" event.
     */
    public function updated(Task $task): void
    {
        //
    }

    /**
     * Handle the Task "deleted" event.
     */
    public function deleted(Task $task): void
    {
        //
    }

    /**
     * Handle the Task "restored" event.
     */
    public function restored(Task $task): void
    {
        //
    }

    /**
     * Handle the Task "force deleted" event.
     */
    public function forceDeleted(Task $task): void
    {
        //
    }
}
