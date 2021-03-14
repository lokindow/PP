<?php

namespace Src\Components\Users\Infrastructure\Persistences;

use Src\Libs\TranslateProperties;
use Src\Libs\Utils;

use Src\Components\Users\Domain\User;
use Src\Components\Users\Domain\Interfaces\IUserRepository;

class UserRepository implements IUserRepository
{

    protected $objTranslator;
    protected $objUtils;

    public function __construct(UserModel $model)
    {
        $this->objTranslator = new TranslateProperties(array_merge(UserModel::$arrProperties));
        $this->objUtils = new Utils();
        $this->model = $model;
    }

    public function find(User $objUser): array
    {
        try {

            if ($objUser->getType() == "user") {
                $arrFilter = ['cpf' => $objUser->getCpf()];
            } else {
                $arrFilter = ['cnpj' => $objUser->getCnpj()];
            }

            $arrFilterEmail = ['email' => $objUser->getEmail()];

            $objModel = $this->model->where($arrFilter)->orWhere($arrFilterEmail)->get();

            if ($objModel->count() !== 0) {
                $this->model = $objModel;
            } else {
                return [];
            }
            return $this->objTranslator->getTranslatedObj($objModel->toArray(), "Output");
        } catch (\Exception $e) {
            $this->objOutput->onError("custom.validation_error", 422, []);
        }
    }

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

    public function save(User $objUser): array
    {
        $arrResultFind = $this->find($objUser);
        if (!empty($arrResultFind)) {
            return [
                "validation" => 'validation.required',
                "extra" => ['key' => 'cpf e email', 'attribute' => 'email ou cpf inválido'],
                "error" => TRUE
            ];
        }

        try {
            $this->model->fill($this->objUtils->entityToArray($objUser));
            $this->model->save();

            return $this->model->toArray();
        } catch (\Exception $e) {
            return $this->objUtils->getFormattedErrorMessage("custom.generic_error", 500, []);
        }
    }
}
