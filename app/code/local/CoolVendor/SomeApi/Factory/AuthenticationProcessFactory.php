<?php

namespace CoolVendor\SomeApi\Factory;

use CoolVendor\SomeApi\Classes\AuthenticationProcess;

class AuthenticationProcessFactory
{
    public function createProcess()
    {
        return new AuthenticationProcess();
    }
}