<?php

namespace Src\Libs;

class TranslateProperties
{
    //en-us => pt-br (Database)
    //client (Front/Legacy) => database
    //business => code
    private $properties;

    public function __construct($properties)
    {
        $this->properties = $properties;
    }

    private function getOutputProp(string $strProperty)
    {
        return array_search($strProperty, $this->properties) ? array_search($strProperty, $this->properties) : $strProperty;
    }

    private function getInputProp(string $strProperty)
    {
        return key_exists($strProperty, $this->properties) ? $this->properties[$strProperty] : $strProperty;
    }

    /**
     * Checks if key is a string and what is the direction of translation to choose the right method (getOutputProp or getInputProp)
     * If isn't a string, it will return the key. It's useful for numbers.
     *
     * @param [type] $key
     * @param string $strDirection
     * @return void
     */
    private function getKey($key, string $strDirection)
    {
        return gettype($key) == "string" ? $this->{"get" . $strDirection . "Prop"}($key) : $key;
    }

    /**
     * Checks whether the value is an object or array to use getTranslatedObj as a recursive translation flow.
     * If isn't an object/array, it will return the value.
     *
     * @param [type] $value
     * @param string $strDirection
     * @return void
     */
    private function getValue($value, string $strDirection)
    {
        switch (gettype($value)) {
            case 'object':
            case 'array':
                return $this->getTranslatedObj($value, $strDirection);
            default:
                return $value;
        }
    }

    /**
     * Return a translated object with the same type of $objOriginal
     *
     * @param [type] $objOriginal
     * @param string $strDirection (Input or Output)
     * @return void
     */
    public function getTranslatedObj($objOriginal, string $strDirection)
    {
        $arrReturn = [];
        foreach ($objOriginal as $key => $value) {
            $arrReturn[$this->getKey($key, $strDirection)] = $this->getValue($value, $strDirection);
        }
        settype($arrReturn, gettype($objOriginal));
        return $arrReturn;
    }

    /**
     * Return the translated array of Entity
     * As: $arrReturn[key_pt_br] => 'value'; //From $objEntity->getKeyUsEn();

     * @param [type] $objEntity
     * @see $arrProperties of {*}EloquentModel.php
     * $key = us_en, $value = pt_br
     * @return array
     */
    public function getTranslatedEntity($objEntity): array
    {
        $objUtils = new Utils();
        $arrReturn = [];
        foreach ($this->properties as $key => $value) {
            $strMethod = "get" . $objUtils->getCamelizedText($key);
            if (method_exists($objEntity, $strMethod) && $objEntity->{$strMethod}()) {
                $arrReturn[$value] = $objEntity->{$strMethod}();
            }
        }
        return $arrReturn;
    }
}
