<?php

namespace CoolVendor\SomeApi\Classes;


use CoolVendor\SomeApi\Interfaces\AuthenticationProcessInterface;

class AuthenticationProcess implements AuthenticationProcessInterface
{
    public function start($token)
    {
        $collection = null;

        if ( !is_null($token) ) {
            $token_inspect_in_missing = \Mage::getModel('coolvendorsomeapi/birrers')->getCollection()
                ->getItemByColumnValue('value', $token);
        }

        return is_null($token_inspect_in_missing);
    }
}