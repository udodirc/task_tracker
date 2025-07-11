<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        \App\Events\TaskCreated::class => [
            \App\Listeners\SendTaskCreatedTelegramNotification::class,
            \App\Listeners\SendTaskCreatedEmailNotification::class,
        ],
    ];

    public function boot(): void
    {
        //
    }
}
