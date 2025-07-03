<?php

namespace App\Enums;

enum TaskEnum: int
{
    case New = 1;
    case InProgress = 2;
    case Done = 3;

    public function label(): string
    {
        return match ($this) {
            self::New => 'new',
            self::InProgress => 'in_progress',
            self::Done => 'done'
        };
    }
}
