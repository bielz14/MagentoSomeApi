<?php

namespace CoolVendor\SomeApi\Factory\ApiProcess;

abstract class ApiProcessFactoryMethod
{
    const FORMAT_ONE = 'One';
    const FORMAT_TWO = 'Two';

    abstract protected function createProcess($format);

    public function create($formatProcess, $params)
    {
        $process = $this->createProcess($formatProcess);
        //в отличие от других фабрик мы прям внутри выполняем проверку класса на instance,
        // потому что здесь же, с помощью этого класса мы запускаем старт процесса
        $inspectClass = 'CoolVendor\SomeApi\Classes\ApiProcess\ApiProcess'.$formatProcess;
        if( get_class($process) === $inspectClass ) {
            $responseCommand = $process->start($params);
            return $responseCommand;
        }else{
            return false;
        }
    }
}