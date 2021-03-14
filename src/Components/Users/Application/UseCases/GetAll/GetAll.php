<?php

namespace Src\Components\Users\Application\UseCases\GetAll;

use Src\Components\Users\Application\UseCases\GetAll\GetAllOutput;
use Src\Components\Users\Domain\Interfaces\IUserRepository;

/**
 * Get GetAll of Users
 *
 */
class GetAll
{

  protected $objUserRepository;
  protected $objOutput;

  public function __construct(IUserRepository $objUserRepository)
  {
    $this->objUserRepository = $objUserRepository;
    $this->objOutput = new GetAllOutput();
  }

  public function run()
  {
    //List save in DB
    
    $arrResult = $this->objUserRepository->all();

    $this->objOutput->prepare($arrResult);

    return $this->objOutput;
  }
}
