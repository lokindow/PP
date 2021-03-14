<?php

namespace Src\Components\Wallet\Infrastructure\Externals;

use Src\Libs\APICaller;
use Src\Libs\Utils;
use Src\Libs\Log;

use Src\Components\Wallet\Domain\Interfaces\ISendNotificationApi;
use Src\Components\Wallet\Domain\Wallet;

class SendNotificationApi implements ISendNotificationApi
{

    protected $strBaseUrlAPI = "https://run.mocky.io/v3/b19f7b9f-9cbf-4fc6-ad22-dc30601aec04";
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

    public function sendData($arrUsers)
    {
        $arrListNotification = [
            $arrUsers['payer']['name'] => $arrUsers['payer']['email'],
            $arrUsers['payee']['name'] => $arrUsers['payee']['email']
        ];

        $arrData = $this->objApiCaller->sendRequest("POST", "", $arrListNotification);

        return $arrData["status"] == 200 ? TRUE : FALSE;
    }
}
