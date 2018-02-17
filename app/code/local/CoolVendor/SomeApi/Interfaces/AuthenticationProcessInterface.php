<?php

namespace CoolVendor\SomeApi\Interfaces;

interface AuthenticationProcessInterface
{
    public function start($token);
}