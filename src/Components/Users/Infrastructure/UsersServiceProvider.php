<?php

namespace Src\Components\Users\Infrastructure;

use Illuminate\Support\ServiceProvider;


class UsersServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //IoC

        // Persistences
        $this->app->bind('Src\Components\Users\Domain\Interfaces\IUserRepository', 'Src\Components\Users\Infrastructure\Persistences\UserRepository');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        include base_path('src/Components/Users/Infrastructure/routes.php');
    }
}
