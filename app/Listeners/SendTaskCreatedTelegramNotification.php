<?php

namespace App\Listeners;

use App\Events\TaskCreated;
use App\Services\TelegramService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendTaskCreatedTelegramNotification
{
    protected TelegramService $telegram;

    /**
     * Create the event listener.
     */
    public function __construct(TelegramService $telegram)
    {
        $this->telegram = $telegram;
    }

    /**
     * Handle the event.
     */
    public function handle(TaskCreated $event)
    {
        $task = $event->task;

        $message = "Новая задача создана!\n\n".
            "Название: {$task->title}\n".
            "Кто создал: {$task->createdBy->name}\n".
            "Назначена: " . ($task->assignedBy ? $task->assignedBy->name : 'Не назначена') . "\n".
            "Статус: {$task->status->name}";

        $this->telegram->sendMessage($message);
    }
}
