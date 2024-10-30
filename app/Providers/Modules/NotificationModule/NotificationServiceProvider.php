<?php

namespace App\Providers\Modules\NotificationModule;

use App\Interfaces\NotificationModule\Notification\NotificationReadInterface;
use App\Interfaces\NotificationModule\Notification\NotificationWriteInterface;
use App\Repositories\NotificationModule\Notification\NotificationReadRepository;
use App\Repositories\NotificationModule\Notification\NotificationWriteRepository;
use Illuminate\Support\ServiceProvider;

class NotificationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(NotificationReadInterface::class,NotificationReadRepository::class);
        $this->app->bind(NotificationWriteInterface::class,NotificationWriteRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
    }
}
