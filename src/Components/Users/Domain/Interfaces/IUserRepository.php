<?php

namespace Src\Components\Users\Domain\Interfaces;

use Src\Components\Users\Domain\User;

interface IUserRepository
{
    public function all(): array;
    public function save(User $objUser): array;
}
