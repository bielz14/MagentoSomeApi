<?php

namespace CoolVendor\SomeApi\Classes\ApiProcess;

use CoolVendor\SomeApi\Interfaces\ApiProcessInterface;
use CoolVendor\SomeApi\Factory\ValidatorFactory;
use CoolVendor\SomeApi\Factory\Handler\HandlerFactory;

class ApiProcessOne implements ApiProcessInterface
{
    const FORMAT_PROCESS = 'One';

    public $commandHandler;
    public $commandInput;
    public $commandProperty = null;

    public function start($params)
    {
        $validator = (new ValidatorFactory())->create();

        if( get_class($validator) === 'CoolVendor\SomeApi\Classes\Validator' ){

            $commandData = $validator->getValidationData(self::FORMAT_PROCESS, $params);

            $this->commandHandler = $commandData['handler'];
            $this->commandInput = $commandData['input'];
            $this->commandProperty = $commandData['property'];

            if ($commandData) {
                //с помощью фабрики создаем handler под названием "РецептПродуктов",
                // с помощью которого выполним процесс их приготовления (получения)
                $productsReceiptHandler = (new HandlerFactory())->create($this->commandHandler);

                if( get_class($productsReceiptHandler) === 'CoolVendor\SomeApi\Classes\ProductsReceiptHandlers\\'.$this->commandHandler.'Handler' ){
                    if ( !is_null($this->commandProperty) ) {
                        return $productsReceiptHandler->executeProcess($this->commandInput, $this->commandProperty);
                    }
                    return $productsReceiptHandler->executeProcess($this->commandInput);
                }
            }
        }
        return false;
    }
}