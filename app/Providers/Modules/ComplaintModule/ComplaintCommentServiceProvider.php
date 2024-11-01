<?php

namespace App\Providers\Modules\ComplaintModule;

use App\Interfaces\ComplaintModule\ComplaintComment\ComplaintCommentReadInterface;
use App\Interfaces\ComplaintModule\ComplaintComment\ComplaintCommentWriteInterface;
use App\Repositories\ComplaintModule\ComplaintComment\ComplaintCommentReadRepository;
use App\Repositories\ComplaintModule\ComplaintComment\ComplaintCommentWriteRepository;
use Illuminate\Support\ServiceProvider;

class ComplaintCommentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(ComplaintCommentReadInterface::class,ComplaintCommentReadRepository::class);
        $this->app->bind(ComplaintCommentWriteInterface::class,ComplaintCommentWriteRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
    }
}
