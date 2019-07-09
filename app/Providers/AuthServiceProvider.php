<?php

namespace App\Providers;

use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy', 
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('isAdmin', function( $user ) {
            return $user->user_group === 'admin';
        });

        Gate::define('isSupport', function( $user ) {
            return $user->user_group === 'support';
        });

        Gate::define('isVip', function( $user ) {
            return $user->user_group === 'vip';
        });

        Passport::routes();
        //
    }
}
