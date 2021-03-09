<?php

namespace Src\Components\Users\Infrastructure\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

use Src\Components\Users\Application\UseCases\GetAll\GetAll;

use Src\Components\Users\Application\UseCases\RegisterUser\RegisterUser;
use Src\Components\Users\Application\UseCases\RegisterUser\RegisterUserInput;



class UserController extends Controller
{
    protected $objGetAll;
    protected $objRegisterUserUsecase;
    protected $objUserPresenter;

    public function __construct(
        GetAll $objGetAll,
        RegisterUser $objRegisterUserUsecase
    ) {
        $this->objGetAll = $objGetAll;
        $this->objRegisterUserUsecase = $objRegisterUserUsecase;
    }

    /**
     * GetAll of Users
     *
     * @param  Request  $objRequest
     * @return Json
     */
    public function getAll(Request $objRequest): JsonResponse
    {
        $objResult = $this->objGetAll->run();

        return response()->json($objResult, !empty($objResult->data) ? 200 : $objResult->error->status);
    }

    /**
     * Register new user
     *
     * @param  Request  $objRequest
     * @return Json
     */
    public function save(Request $objRequest): JsonResponse
    {
        $objInput = new RegisterUserInput($objRequest->all());
        $objResult = $this->objRegisterUserUsecase->run($objInput->toArray());

        return response()->json($objResult, !empty($objResult->data) ? 200 : $objResult->error->status);
    }
}
