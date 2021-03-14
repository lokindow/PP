<?php

namespace Src\Components\Wallet\Infrastructure\Externals;

use Illuminate\Support\Facades\DB;

use Src\Libs\Utils;
use Src\Libs\Log;

use Src\Components\Wallet\Domain\Wallet;

use Src\Components\Wallet\Domain\Interfaces\IExternalUserPermissionRepository;

class ExternalUserPermissionRepository implements IExternalUserPermissionRepository
{
    protected $objUtils;

    public function __construct()
    {
        $this->objUtils = new Utils();
        $this->objLog = new Log();
    }

    public function getUsersTransaction(Wallet $objWallet): array
    {
        try {
            $arrResultPayer = DB::table('user')
                ->where([
                    ['id', '=', $objWallet->getPayer()],
                ])
                ->get()
                ->last();

            $arrResultPayee = DB::table('user')
                ->where([
                    ['id', '=', $objWallet->getPayee()],
                ])
                ->get()
                ->last();

            $arrResult = [
                "payer" => (array)$arrResultPayer ?? [],
                "payee" => (array)$arrResultPayee ?? []
            ];

            return empty($arrResult['payer']) || empty($arrResult['payee']) ? [] : $arrResult;
        } catch (\Exception $e) {
            $this->objLog->writeLine('error', __METHOD__ . ' - Exception:', $e->getMessage());
            return ["error" => $e->getMessage()];
        }
    }

    public function validatePayer($arrInput)
    {
        if ($arrInput['payer']['type'] != "seller") {
            return [];
        } else {
            return [
                "validation" => 'validation.required',
                "extra" => ['key' => 'type user', 'attribute' => 'usuário do tipo vendedor não pode tranferir']
            ];
        }
    }
}
