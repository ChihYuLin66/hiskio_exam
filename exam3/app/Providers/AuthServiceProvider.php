<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // user
        Gate::define('user-view', 'App\Policies\UserPolicy@view');

        // account 
        // Gate::define('account-view', 'App\Policies\AccountPolicy@view');
        Gate::define('account-update', 'App\Policies\AccountPolicy@update');
    }
}
