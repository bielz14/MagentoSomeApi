<?php

namespace CoolVendor\SomeApi\Interfaces;

interface ValidatorInterface
{
    public function getValidationData($formatProcess, $params);
}