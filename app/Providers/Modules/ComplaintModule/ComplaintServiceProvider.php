<?php

namespace App\Providers\Modules\ComplaintModule;

use App\Interfaces\ComplaintModule\Complaint\ComplaintReadInterface;
use App\Interfaces\ComplaintModule\Complaint\ComplaintWriteInterface;
use App\Repositories\ComplaintModule\Complaint\ComplaintReadRepository;
use App\Repositories\ComplaintModule\Complaint\ComplaintWriteRepository;
use Illuminate\Support\ServiceProvider;

class ComplaintServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(ComplaintReadInterface::class,ComplaintReadRepository::class);
        $this->app->bind(ComplaintWriteInterface::class,ComplaintWriteRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
    }
}
