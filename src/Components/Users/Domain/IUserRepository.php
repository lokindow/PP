<?php

namespace Src\Components\Users\Domain;

interface IUserRepository
{
    public function all(): array;
    public function save(User $objUser): array;
}
