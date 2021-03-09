<?php

namespace Src\Libs;

use Src\Libs\TranslateProperties;
use Src\Libs\Utils;

class CommonInput
{

  /**
   * Data
   *
   * @var array
   */
  public $arrData;

  /**
   * Attributes
   *
   * @var array
   */
  protected $arrAttributes;

  /**
   * Rules
   *
   * @var array
   */
  protected $arrRules;

  /**
   * Constructor of CommotInput, that hydrate arrData and if exist arrayInputToDatabase, translate keys
   *
   * @param array $arrArgs
   */
  public function __construct(array $arrArgs)
  {
    $objUtils = new Utils();

    //It will hydrate arrData only with existing elements in arrAttributes
    $this->arrData = $objUtils->array_intersect_key_recursive($arrArgs, array_flip($this->arrAttributes));

    //If there is data in arrayInputToDatabase (from->to), it will translate keys
    if (!empty($this->arrInputToDatabase)) {
      $objTranslator = new TranslateProperties($this->arrInputToDatabase);
      $this->arrData = $objTranslator->getTranslatedObj($this->arrData, "Input");
    }
  }

  /**
   * Replacing the function "array_intersect_key_recursive", which does not add object and array, returns void
   *
   * @return void
   */
  public function selfHydrating(array $arrArgs): void
  {
    foreach ($this->arrHydratingKeys as $value) {
      if (isset($arrArgs[$value])) {
        $this->arrData[$value] = $arrArgs[$value];
      }
    }
  }

  /**
   * Override "toArray" method to return just array $arrData
   *
   * @return void
   */
  public function toArray(): array
  {
    return (array) $this->arrData;
  }

  /**
   * Gets the value of array Data
   */
  public function getData(): array
  {
    return $this->arrData;
  }

  /**
   * Gets the value of array Rules
   */
  public function getRules(): array
  {
    return $this->arrRules;
  }
}
