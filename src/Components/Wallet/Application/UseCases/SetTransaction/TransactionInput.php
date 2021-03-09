<?php

namespace Src\Components\Wallet\Application\UseCases\SetTransaction;

use Src\Libs\CommonInput;

class TransactionInput extends CommonInput
{
    protected $arrAttributes = ["value", "payee", "payer"];

    public function __construct($arrArgs)
    {
        parent::__construct($arrArgs);
    }
}
