<?php

namespace App\Data\Admin\Task;

use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;

class TaskCreateData extends Data
{
    public string $title;
    public string $description;

    public function __construct(
        string $title,
        string $description
    )
    {
        $this->title = $title;
        $this->description = $description;
    }

    public static function rules(...$args): array
    {
        return [
            'title' => [
                new Required(),
                new StringType(),
                new Max(100)
           ],
           'description' => [
                new Required(),
                new StringType()
           ]
        ];
    }
}
