<?php

namespace Src\Components\Wallet\Infrastructure\Persistences;

use Illuminate\Database\Eloquent\Model;

class WalletModel extends Model
{
    protected $table = 'transaction';
    protected $primaryKey = 'id';
    const CREATED_AT = NULL;
    const UPDATED_AT = NULL;


    public static $arrProperties = [
        'id',
        'value',
        'payer',
        'payee',
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
