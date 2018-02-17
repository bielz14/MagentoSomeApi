<?php

namespace CoolVendor\SomeApi\Factory\ApiProcess;

use CoolVendor\SomeApi\Classes\ApiProcess\ApiProcessOne;
use CoolVendor\SomeApi\Classes\ApiProcess\ApiProcessTwo;

class ApiProcessFactory extends ApiProcessFactoryMethod
{
    protected function createProcess($type)
    {
        switch ($type) {
            case parent::FORMAT_ONE:
                return new ApiProcessOne();
            case parent::FORMAT_TWO:
                return new ApiProcessTwo();
            default:
                return false;
        }
    }
}