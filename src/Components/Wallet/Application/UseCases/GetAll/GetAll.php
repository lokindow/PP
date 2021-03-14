<?php

namespace Src\Components\Wallet\Application\UseCases\GetAll;

use Src\Components\Wallet\Application\UseCases\GetAll\GetAllOutput;
use Src\Components\Wallet\Domain\Interfaces\IWalletRepository;

/**
 * GetAllTransaction of Wallet
 *
 */
class GetAll
{

  protected $objWalletRepository;
  protected $objOutput;

  public function __construct(IWalletRepository $iWalletRepository)
  {
    $this->objWalletRepository = $iWalletRepository;
    $this->objOutput = new GetAllOutput();
  }

  public function run()
  {
    //List save in DB

    $arrResult = $this->objWalletRepository->all();

    $this->objOutput->prepare($arrResult);

    return $this->objOutput;
  }
}
