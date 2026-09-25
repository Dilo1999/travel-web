<?php

namespace App\Providers;

use App\Models\Destination;
use App\Models\Package;
use App\Models\User;
use App\Policies\DestinationPolicy;
use App\Policies\PackagePolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Destination::class => DestinationPolicy::class,
        Package::class => PackagePolicy::class,
        User::class => UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
