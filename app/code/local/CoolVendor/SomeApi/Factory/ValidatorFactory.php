<?php

namespace CoolVendor\SomeApi\Factory;

use CoolVendor\SomeApi\Classes\Validator;

class ValidatorFactory
{
    public function create()
    {
        return new Validator();
    }
}