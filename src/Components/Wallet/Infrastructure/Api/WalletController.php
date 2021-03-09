<?php

namespace Src\Components\Wallet\Infrastructure\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

use Src\Components\Wallet\Application\UseCases\GetAll\GetAll;

use Src\Components\Wallet\Application\UseCases\SetTransaction\Transaction;
use Src\Components\Wallet\Application\UseCases\SetTransaction\TransactionInput;



class WalletController extends Controller
{
    protected $objGetAll;
    protected $objTransactionUsecase;
    protected $objTransactionPresenter;

    public function __construct(
        GetAll $objGetAll,
        Transaction $objTransaction
    ) {
        $this->objGetAll = $objGetAll;
        $this->objTransaction = $objTransaction;
    }

    /**
     * GetAllTransaction of Wallet
     *
     * @param  Request  $objRequest
     * @return Json
     */
    public function getAllTransaction(Request $objRequest): JsonResponse
    {
        $objResult = $this->objGetAll->run();

        return response()->json($objResult, !empty($objResult->data) ? 200 : $objResult->error->status);
    }

    /**
     * Register new Transaction
     *
     * @param  Request  $objRequest
     * @return Json
     */
    public function setTransaction(Request $objRequest): JsonResponse
    {
        $objInput = new TransactionInput($objRequest->all());
        $objResult = $this->objTransaction->run($objInput->toArray());

        return response()->json($objResult, !empty($objResult->data) ? 200 : $objResult->error->status);
    }
}
