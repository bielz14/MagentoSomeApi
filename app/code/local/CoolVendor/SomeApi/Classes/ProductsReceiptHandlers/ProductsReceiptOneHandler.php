<?php

namespace CoolVendor\SomeApi\Classes\ProductsReceiptHandlers;

use CoolVendor\SomeApi\Interfaces\HandlerInterface;

class ProductsReceiptOneHandler implements HandlerInterface
{
    public $limit;
    public $products = null;

    public function executeProcess($commandInput, $commandProperty=NULL){

        $this->limit = $commandInput['limit'];

        //каждый разраб сам пишет в конфигах в разделе property свойства которые нужно применить к полученной коллекции
        //и потом здесь происходит приминение property к коллекции
        if( !is_null($commandProperty) ){
            $property_value = $commandProperty['order by'];

            $this->products = \Mage::getModel('catalog/product')
                ->getCollection()
                ->addAttributeToSelect('*')
                ->setPageSize($this->limit)
                ->setOrder($property_value);
        }else{
            $this->products = \Mage::getModel('catalog/product')
                ->getCollection()
                ->addAttributeToSelect('*')
                ->setPageSize($this->limit);
        }

        if( is_null($this->products) ) {
            return false;
        }

        return json_encode( $this->products->getData(), JSON_UNESCAPED_UNICODE);
    }
}