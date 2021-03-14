<?php

namespace Src\Libs;

use Src\Libs\Utils;
use Src\Libs\Log;

class APICaller
{
    protected $strBaseUrl;
    protected $arrHeader = [];

    protected $objUtils;

    public function __construct($strBaseUrl = "", array $arrHeader)
    {
        $this->objUtils = new Utils();
        $this->objLog = new Log();

        $this->strBaseUrl = $strBaseUrl;
        $this->setHeader($arrHeader);
    }

    /**
     * Set the header
     *
     * @param array $arrHeader
     * @return void
     */
    public function setHeader(array $arrHeader) : void
    {
        $this->arrHeader = $arrHeader;
    }

    /**
     * Returns the header array
     *
     * @return array
     */
    public function getHeader() : array
    {
        return $this->arrHeader;
    }

    /**
     * Send a request to external API, using the defined method, endpoint and data.
     *
     * @param string $strMethod
     * @param string $strEndpoint
     * @param string $mixData
     * @return array
     */
    public function sendRequest(string $strMethod, string $strEndpoint, $mixData = "") : array
    {

        $objCurl = \curl_init();
        //Setting particular stuffs of HTTP METHODS
        switch ($strMethod) {
            case "POST":
                curl_setopt($objCurl, CURLOPT_POST, true);
                if ($mixData) {
                    curl_setopt($objCurl, CURLOPT_POSTFIELDS, $mixData);
                }
                break;
            case "PUT":
                curl_setopt($objCurl, CURLOPT_CUSTOMREQUEST, "PUT");
                if ($mixData) {
                    curl_setopt($objCurl, CURLOPT_POSTFIELDS, $mixData);
                }
                break;
            default:
                if ($mixData) {
                    $strEndpoint = sprintf("%s?%s", $strEndpoint, http_build_query($mixData));
                }
        }
        //Set cURL options
        curl_setopt($objCurl, CURLOPT_URL, $this->strBaseUrl.$strEndpoint);
        curl_setopt($objCurl, CURLOPT_HEADER, 1);
        curl_setopt($objCurl, CURLOPT_HTTPHEADER, $this->getHeader());
        curl_setopt($objCurl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($objCurl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($objCurl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($objCurl, CURLOPT_TIMEOUT, 10); //Set 10 seconds of timeout

        //Execute cURL connection
        $strResponse = curl_exec($objCurl);

        //Getting errors if exists
        $intCurlErrno = curl_errno($objCurl);

        $this->objLog->writeLine('info',__METHOD__." - Curl - objCurl:",curl_getinfo($objCurl));

        //return error if exists
        if ($intCurlErrno > 0) {
            $arrError = $this->objUtils->getCurlError($intCurlErrno);
            $this->objLog->writeLine('error',__METHOD__." - Curl error - arrError:",$arrError);
            return $arrError;
        } else {
            //Get Http Status Code
            $intHttpCode = curl_getinfo($objCurl, CURLINFO_HTTP_CODE);

            //Get Header Size
            $intHeaderSize = curl_getinfo($objCurl, CURLINFO_HEADER_SIZE);

            //Extract Header
            $strHeader = substr($strResponse, 0, $intHeaderSize);

            //Extract Body
            $strBody = urldecode(substr($strResponse, $intHeaderSize));

            $this->objLog->writeLine('info',__METHOD__." - Response - intHttpCode, strBody:", [
                "intHttpCode" => $intHttpCode,
                "strBody" => $strBody
            ]);
        }

        //Close cURL connection
        curl_close($objCurl);

        return [
            "status" => $intHttpCode,
            "header" => $strHeader,
            "data" => $strBody
        ];
    }
}
