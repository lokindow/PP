<?php

namespace Src\Components\Users\Application\UseCases\RegisterUser;

use Src\Components\Users\Application\UseCases\RegisterUser\RegisterUserOutput;
use Src\Components\Users\Domain\Interfaces\IUserRepository;
use Src\Components\Users\Domain\User;

/**
 * Register a new user
 *
 */
class RegisterUser
{

  protected $objUserRepository;
  protected $objOutput;

  public function __construct(IUserRepository $objUserRepository)
  {
    $this->objUserRepository = $objUserRepository;
    $this->objOutput = new RegisterUserOutput();
  }

  public function run($arrInput)
  {

    $objUser = new User($arrInput);
    
    //Validate Input in Object
    $arrValidationErrors = $objUser->validate();


    if (!empty($arrValidationErrors)) {
      $this->objOutput->onError("custom.validation_error", 422, $arrValidationErrors);
      return $this->objOutput;
    }

    //Save in DB

    $arrResult = $this->objUserRepository->save($objUser);

    if (!empty($arrResult['error'])) {

      $this->objOutput->onError("custom.validation_error", 422, $arrResult);
      return $this->objOutput;
    }

    $this->objOutput->prepare($arrResult);

    return $this->objOutput;
  }
}
