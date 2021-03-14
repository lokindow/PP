<?php

namespace Src\Components\Wallet\Domain\Interfaces;

use Src\Components\Wallet\Domain\Wallet;

interface IExternalUserPermissionRepository
{
    public function getUsersTransaction(Wallet $objWallet): array;

    public function validatePayer($arrInput);
}
