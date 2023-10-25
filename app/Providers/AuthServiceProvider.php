<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Utilisateur;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('isAdmin', function(Utilisateur $user){
            return $user->isAdmin == 1;
        });

        Gate::define('isProf', function(Utilisateur $user){
            return $user->isProf == 1;
        });

        Gate::define('isEleve', function(Utilisateur $user){
            return $user->isProf == 0;
        });
    }
}
