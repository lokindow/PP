<?php

namespace Src\Components\Users\Application\UseCases\RegisterUser;

use Src\Libs\CommonInput;

class RegisterUserInput extends CommonInput
{
    protected $arrAttributes = ["name", "email", "cpf", "cnpj", "password"];

    public function __construct($arrArgs)
    {
        parent::__construct($arrArgs);
    }
}
