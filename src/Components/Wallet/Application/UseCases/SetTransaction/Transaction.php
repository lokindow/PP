<?php

namespace Src\Components\Wallet\Application\UseCases\SetTransaction;

use Src\Components\Wallet\Application\UseCases\SetTransaction\TransactionOutput;
use Src\Components\Wallet\Domain\Interfaces\IWalletRepository;
use Src\Components\Wallet\Domain\Wallet;
use Src\Components\Wallet\Domain\Interfaces\IExternalUserPermissionRepository;
use Src\Components\Wallet\Domain\Interfaces\IAutorizationTransactionApi;
use Src\Components\Wallet\Domain\Interfaces\ISendNotificationApi;


/**
 * Register a new Transaction
 *
 */
class Transaction
{

  protected $objWalletRepository;
  protected $objExternalUserPermissionRepository;
  protected $objAutorizationTransactionApi;
  protected $objSendNotificationApi;
  protected $objOutput;

  public function __construct(IWalletRepository $iWalletRepository, IExternalUserPermissionRepository $iExternalUserPermissionRepository, IAutorizationTransactionApi $iAutorizationTransactionApi, ISendNotificationApi $iSendNotificationApi)
  {
    $this->objWalletRepository = $iWalletRepository;
    $this->objExternalUserPermissionRepository = $iExternalUserPermissionRepository;
    $this->objAutorizationTransactionApi = $iAutorizationTransactionApi;
    $this->objSendNotificationApi = $iSendNotificationApi;
    $this->objOutput = new TransactionOutput();
  }

  public function run($arrInput)
  {

    $objWallet = new Wallet($arrInput);

    // Valid objects received by the input
    $arrValidationErrors = $objWallet->validate();

    //  Get Users used in Transaction
    $arrUsers = $this->objExternalUserPermissionRepository->getUsersTransaction($objWallet);
    // Valid if the payer is not a seller
    $arrValidationErrors = $this->objExternalUserPermissionRepository->validatePayer($arrUsers);

    // Check errors validade
    if (!empty($arrValidationErrors)) {
      $this->objOutput->onError("custom.validation_error", 422, $arrValidationErrors);
      return $this->objOutput;
    }

    // Check availability of external authorization
    if (!$this->objAutorizationTransactionApi->checkAvailability()) {
      $this->objOutput->onError("custom.generic_error", 500, []);
      return $this->objOutput;
    }

    //Save in DB
    $arrResult = $this->objWalletRepository->save($objWallet);

    if ($this->objSendNotificationApi->checkAvailability() and $this->objSendNotificationApi->sendData($arrUsers)) {

      $this->objOutput->arrPrepare($arrResult, TRUE);
    } else {

      $this->objOutput->arrPrepare($arrResult, FALSE);
    }

    return $this->objOutput;
  }
}
