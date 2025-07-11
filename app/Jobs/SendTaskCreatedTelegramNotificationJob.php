<?php

namespace App\Jobs;

use App\Models\Task;
use App\Services\TelegramService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendTaskCreatedTelegramNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(protected Task $task) {}

    public function handle(TelegramService $telegram): void
    {
        try {
            $message = "Новая задача создана!\n\n".
                "Название: {$this->task->title}\n".
                "Кто создал: {$this->task->createdBy->name}\n".
                "Назначена: " . ($this->task->assignedBy ? $this->task->assignedBy->name : 'Не назначена') . "\n".
                "Статус: {$this->task->status->name}";

            $telegram->sendMessage($message);
        } catch (\Throwable $e) {
            Log::error('Telegram job failed: '.$e->getMessage());
            throw $e; // чтобы не "скрывать" исключение от воркера
        }
    }
}
