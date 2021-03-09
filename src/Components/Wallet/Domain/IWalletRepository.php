<?php

namespace Src\Components\Wallet\Domain;

interface IWalletRepository
{
    public function all(): array;
    
    public function save(Wallet $objWallet): array;
}
