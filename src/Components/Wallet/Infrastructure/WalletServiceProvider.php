<?php

namespace Src\Components\Wallet\Infrastructure;

use Illuminate\Support\ServiceProvider;


class WalletServiceProvider extends ServiceProvider
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
        $this->app->bind('Src\Components\Wallet\Domain\IWalletRepository', 'Src\Components\Wallet\Infrastructure\Persistences\WalletRepository');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        include base_path('src/Components/Wallet/Infrastructure/routes.php');
    }
}
