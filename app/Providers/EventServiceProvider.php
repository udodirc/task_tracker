<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        \App\Events\TaskCreated::class => [
            \App\Listeners\SendTaskCreatedTelegramNotification::class,
        ],
    ];

    public function boot(): void
    {
        //
    }
}
