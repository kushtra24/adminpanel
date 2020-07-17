<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;
use Illuminate\Auth\Access\Response;

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


        Gate::before(function ($user, $ability) {
            if ($user->type === 'admin') {
                return true;
            }
        });

        // if the user is an admin
        Gate::define('isAdmin', function ($user) {
//            return $user->isAdmin;
            return $user->type === 'admin'
                ? Response::allow()
                : Response::deny('You must be a super administrator.');;
        });


        // if the user is an admin
//        Gate::define('isAdminOrAuthor', function ($user) {
////            return $user->isAdmin;
//            return $user->type === 'admin' || $user->type === 'author';
//        });

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
