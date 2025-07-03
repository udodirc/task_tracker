<?php

namespace App\Data\Admin\Task;

use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;

class TaskChangeStatusData extends Data
{
    public int $status;

    public function __construct(
        int $status
    )
    {
        $this->status = $status;
    }

    public static function rules(...$args): array
    {
        return [
            'status' => [
                new Required(),
                new IntegerType()
            ]
        ];
    }
}
