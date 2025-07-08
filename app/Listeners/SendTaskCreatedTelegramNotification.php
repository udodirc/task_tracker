<?php

namespace App\Listeners;

use App\Events\TaskCreated;
use App\Services\TelegramService2;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendTaskCreatedTelegramNotification
{
    protected TelegramService2 $telegram;

    protected string $chatId = 'YOUR_TELEGRAM_CHAT_ID_OR_USER_ID';

    /**
     * Create the event listener.
     */
    public function __construct(TelegramService2 $telegram)
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
            "Статус: {$task->status}";

        $this->telegram->sendMessage($this->chatId, $message);
    }
}
