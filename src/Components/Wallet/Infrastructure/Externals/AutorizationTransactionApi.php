<?php

namespace Src\Components\Wallet\Infrastructure\Externals;

use Src\Libs\APICaller;
use Src\Libs\Utils;
use Src\Libs\Log;

use Src\Components\Wallet\Domain\Interfaces\IAutorizationTransactionApi;

class AutorizationTransactionApi implements IAutorizationTransactionApi
{

    protected $strBaseUrlAPI = "https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6";
    protected $objApiCaller;
    protected $objUtils;
    protected $objLog;


    public function __construct()
    {
        $this->objApiCaller = new APICaller(
            $this->strBaseUrlAPI,
            //Header's array
            [
                "ContentType: application/json",
                "Accept: application/json"
            ]
        );
        $this->objUtils = new Utils();
        $this->objLog = new Log();
    }

    public function checkAvailability()
    {
        $arrData = $this->objApiCaller->sendRequest("GET", "");
        return $arrData["status"] == 200 ? TRUE : FALSE;
    }
}
