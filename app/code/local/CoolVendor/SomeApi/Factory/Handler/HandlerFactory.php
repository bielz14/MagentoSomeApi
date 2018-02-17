<?php

namespace CoolVendor\SomeApi\Factory\Handler;

use CoolVendor\SomeApi\Classes\ProductsReceiptHandlers\ProductsReceiptOneHandler;
use CoolVendor\SomeApi\Classes\ProductsReceiptHandlers\ProductsReceiptTwoHandler;

class HandlerFactory extends HandlerFactoryMethod
{
    protected function createHandler($type)
    {
        switch ($type) {
            case parent::PRODUCTS_RECEIPT_ONE :
                return new ProductsReceiptOneHandler();
            case parent::PRODUCTS_RECEIPT_TWO :
                return new ProductsReceiptTwoHandler();
            default:
                return false;
        }
    }
}