<?php

namespace Src\Components\Users\Infrastructure\Persistences;

use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
    protected $table = 'user';
    protected $primaryKey = 'id';
    const CREATED_AT = NULL;
    const UPDATED_AT = NULL;

    public static $arrProperties = [
        'id',
        'name',
        'email',
        'cpf',
        'cnpj',
        'password',
        'type'
    ];

    public function __construct(array $attributes = [])
    {
        $this->fillable = array_values(self::$arrProperties);
        parent::__construct($attributes);
    }

    public function getTable()
    {
        return $this->table;
    }
}
