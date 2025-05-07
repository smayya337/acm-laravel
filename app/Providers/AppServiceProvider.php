<?php

namespace App\Providers;

use App\Models\Badge;
use App\Models\Event;
use App\Models\Officer;
use App\Models\User;
use App\Policies\BadgePolicy;
use App\Policies\EventPolicy;
use App\Policies\OfficerPolicy;
use App\Policies\UserPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
//    protected array $policies = [
//        Badge::class => BadgePolicy::class,
//        Event::class => EventPolicy::class,
//        Officer::class => OfficerPolicy::class,
//        User::class => UserPolicy::class,
//    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
