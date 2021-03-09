<?php

namespace Src\Libs;

use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class CommonOutput
{

  public $data;
  public $error;

  /**
   * On success, unset "error" and set attribute "data"
   *
   * @param [type] $objResult
   * @return void
   */
  public function onSuccess($objResult)
  {
    unset($this->error);
    $this->data = $objResult;
  }

  /**
   * On error, unset "data" and set attribute "error", with inner attributes error->(message, status and errors)
   *
   * @param [type] $strMsg
   * @param [type] $intStatus
   * @param array $objErrors
   * @return void
   */
  public function onError(string $strMsg, int $intStatus, array $arrErrors = [])
  {
    unset($this->data);
    $this->error = new \stdClass();
    $this->error->message = __($strMsg);
    if (!empty($arrErrors))
      $this->error->errors = $arrErrors;

    throw new HttpException($intStatus, json_encode($this->error));
  }

  /**
   * Prepare Output, defining if returns error or success
   *
   * @param [type] $objResult
   * @return void
   */
  public function prepare($arrResult)
  {
    if (is_array($arrResult) && !empty($arrResult['error'])) {
      $this->onError($arrResult['error']['message'], $arrResult['error']['status']);
    } elseif ($arrResult != null) {
      $this->onSuccess($arrResult);
    }
  }
}
