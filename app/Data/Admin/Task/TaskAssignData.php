<?php

namespace App\Data\Admin\Task;

use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;

class TaskAssignData extends Data
{
    public int $id;

    public function __construct(
        int $id
    )
    {
        $this->id = $id;
    }

    public static function rules(...$args): array
    {
        return [
            'id' => [
                new Required(),
                new IntegerType()
            ]
        ];
    }
}
