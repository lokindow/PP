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
        $this->app->bind('Src\Components\Wallet\Domain\Interfaces\IWalletRepository', 'Src\Components\Wallet\Infrastructure\Persistences\WalletRepository');
        $this->app->bind('Src\Components\Wallet\Domain\Interfaces\IAutorizationTransactionApi', 'Src\Components\Wallet\Infrastructure\Externals\AutorizationTransactionApi');
        $this->app->bind('Src\Components\Wallet\Domain\Interfaces\IExternalUserPermissionRepository', 'Src\Components\Wallet\Infrastructure\Externals\ExternalUserPermissionRepository');
        $this->app->bind('Src\Components\Wallet\Domain\Interfaces\ISendNotificationApi', 'Src\Components\Wallet\Infrastructure\Externals\SendNotificationApi');
        
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
