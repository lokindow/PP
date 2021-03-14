<?php

namespace Src\Components\Wallet\Application\UseCases\SetTransaction;

use Src\Libs\CommonOutput;

class TransactionOutput extends CommonOutput
{
    public function arrPrepare($arrArgs, $boolNotifications)
    {
        $arrArgs['notifiedUsers'] =  $boolNotifications;

        parent::prepare($arrArgs);
    }
}
