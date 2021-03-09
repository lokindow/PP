<?php

namespace Src\Components\Wallet\Application\UseCases\SetTransaction;

use Src\Components\Wallet\Application\UseCases\SetTransaction\TransactionOutput;
use Src\Components\Wallet\Domain\IWalletRepository;
use Src\Components\Wallet\Domain\Wallet;

/**
 * Register a new Transaction
 *
 */
class Transaction
{

  protected $objWalletRepository;
  protected $objOutput;

  public function __construct(IWalletRepository $iWalletRepository)
  {
    $this->objWalletRepository = $iWalletRepository;
    $this->objOutput = new TransactionOutput();
  }

  public function run($arrInput)
  {

    $objWallet = new Wallet($arrInput);

    $arrValidationErrors = $objWallet->validate();


    if (!empty($arrValidationErrors)) {
      $this->objOutput->onError("custom.validation_error", 422, $arrValidationErrors);
      return $this->objOutput;
    }

    //Save in DB

    $arrResult = $this->objWalletRepository->save($objWallet);

    $this->objOutput->prepare($arrResult);

    return $this->objOutput;
  }
}
