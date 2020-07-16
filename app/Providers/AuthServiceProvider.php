<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

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

        // if the user is an admin
        Gate::define('isAdmin', function ($user) {
//            return $user->isAdmin;
            return $user->type === 'admin';
        });
//        if the user is an author
        Gate::define('isAuthor', function ($user) {
//            return $user->isAdmin;
            return $user->type === 'author';
        });
        Gate::define('isUser', function ($user) {
//            return $user->isAdmin;
            return $user->type === 'user';
        });

        Passport::routes();
    }
}
