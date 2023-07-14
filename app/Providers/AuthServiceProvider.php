<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

/**
 * Class AuthServiceProvider.
 */
class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
//        Passport::loadKeysFrom(__DIR__.'/../secrets/oauth');

        // Implicitly grant "Admin" role all permissions
        // This works in the app by using gate-related functions like auth()->user->can() and @can()
        Gate::before(function ($user) {
            return $user->hasAllAccess() ? true : null;
        });

        // Learn when to use this instead: https://docs.spatie.be/laravel-permission/v3/basic-usage/super-admin/#gate-after
//        Gate::after(function ($user) {
//            return $user->hasAllAccess();
//        });
        if (! $this->app->routesAreCached()) {
            Passport::routes();
        }
        Passport::tokensCan([
            'external_admin' => 'Admin user at MAFF ministry',
            'internal_admin' => 'Admin user as general who will apply request farming info',
        ]);
        Passport::tokensExpireIn(now()->addDays(6));
        Passport::refreshTokensExpireIn(now()->addYears(2));
        Passport::personalAccessTokensExpireIn(now()->addDays(12));
    }
}
