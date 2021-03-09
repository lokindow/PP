<?php

namespace Src\Components\Wallet\Domain;

class Wallet
{
    private $id;
    private $value;
    private $payer;
    private $payee;

    public function __construct($arrArgs)
    {
        foreach ($arrArgs as $prop => $value) {
            if (property_exists($this, $prop)) {
                $this->{$prop} = $value;
            }
        }
    }

     /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * Get the value of value
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Get the value of payer
     */
    public function getPayer()
    {
        return $this->payer;
    }

    /**
     * Get the value of payee
     */
    public function getPayee()
    {
        return $this->payee;
    }

    public function validate()
    {
        $arrErrors = [];

        if (is_null($this->value)) {
            $arrErrors[] = [
                "validation" => 'validation.required',
                "extra" => ['key' => 'value', 'attribute' => 'value null']
            ];
        }

        if (is_null($this->payer)) {
            $arrErrors[] = [
                "validation" => 'validation.required',
                "extra" => ['key' => 'payer', 'attribute' => 'payer null']
            ];
        }

        if (is_null($this->payee)) {
            $arrErrors[] = [
                "validation" => 'validation.required',
                "extra" => ['key' => 'payee', 'attribute' => 'payee null']
            ];
        }

        return $arrErrors;
    }
}
