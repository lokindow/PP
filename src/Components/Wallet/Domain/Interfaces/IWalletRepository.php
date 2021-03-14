<?php

namespace Src\Components\Wallet\Domain\Interfaces;

use Src\Components\Wallet\Domain\Wallet;

interface IWalletRepository
{
    public function all(): array;
    
    public function save(Wallet $objWallet): array;
}
