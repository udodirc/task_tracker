<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;
use App\Models\Task;

class TaskStatusUpdated implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public function __construct(public Task $task) {}

    public function broadcastOn(): Channel
    {
        return new Channel('tasks'); // публичный канал
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->task->id,
            'status' => $this->task->status,
        ];
    }

    public function broadcastAs(): string
    {
        return 'TaskStatusUpdated'; // имя события на клиенте
    }
}


