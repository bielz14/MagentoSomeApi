<?php

namespace CoolVendor\SomeApi\Factory\Handler;

abstract class HandlerFactoryMethod
{
    //можно ещё назвать константу HANDLER_ONE,
    // это уже решает каждый программист сам, при создании нового класса хендлера, как ему нравится
    const PRODUCTS_RECEIPT_ONE = 'ProductsReceiptOne';
    const PRODUCTS_RECEIPT_TWO = 'ProductsReceiptTwo';

    abstract protected function createHandler($type);

    public function create($typeHandler)
    {
        $process = $this->createHandler($typeHandler);
        return $process;
    }
}