<?php

namespace CoolVendor\SomeApi\Interfaces;


interface HandlerInterface
{
    public function executeProcess($commandInput, $commandProperty=NULL);
}