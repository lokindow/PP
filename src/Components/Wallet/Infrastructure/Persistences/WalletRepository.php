<?php

namespace Src\Components\Wallet\Infrastructure\Persistences;

use Src\Libs\Utils;
use Src\Libs\TranslateProperties;

use Illuminate\Support\Facades\DB;
use Src\Components\Wallet\Domain\Wallet;
use Src\Components\Wallet\Domain\Interfaces\IWalletRepository;

class WalletRepository implements IWalletRepository
{

    protected $objTranslator;
    protected $objUtils;

    public function __construct(WalletModel $model)
    {
        $this->objTranslator = new TranslateProperties(array_merge(WalletModel::$arrProperties));
        $this->objUtils = new Utils();
        $this->model = $model;
    }

     /**
     * Get all Transaction
     *
     * @return array
     */
    public function all(): array
    {
        try {
            $objModel = $this->model->get();

            if (!empty($objModel) and $objModel->count() !== 0) {
                return $objModel->toArray();
            } else {
                return [];
            }
        } catch (\Exception $e) {
            return $this->objUtils->getFormattedErrorMessage("custom.generic_error", 500, []);
        }
    }

    /**
     * Save new Transaction
     *
     * @param  object  $objWallet
     * @return array
     */
    public function save(Wallet $objWallet): array
    {
        DB::beginTransaction();
        try {
            // Structure the attributes to be inserted
            $this->model->fill($this->objUtils->entityToArray($objWallet));
            $this->model->save();

            DB::commit();
            return $this->model->toArray();
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->objUtils->getFormattedErrorMessage("custom.generic_error", 500, []);
        }
    }
}
