<?php

namespace CoolVendor\SomeApi\Classes\ProductsReceiptHandlers;

use CoolVendor\SomeApi\Interfaces\HandlerInterface;

class ProductsReceiptTwoHandler implements HandlerInterface
{
    public $limit;
    public $products = null;
    public $xml = false;

    public function executeProcess($commandInput, $commandProperty=NULL)
    {

        $this->limit = $commandInput['limit'];

        //каждый разраб сам пишет в конфигах в разделе property свойства которые нужно применить к полученной коллекции
        //и потом здесь происходит приминение property к коллекции
        if( !is_null($commandProperty) ){
            $property_value = $commandProperty['order by'];

            $this->products = \Mage::getModel('catalog/product')
                ->getCollection()
                ->addAttributeToSelect('*')
                ->setPageSize($this->limit)
                ->setOrder($property_value);//->toXML();
        }else{
            $this->products = \Mage::getModel('catalog/product')
                ->getCollection()
                ->addAttributeToSelect('*')
                ->setPageSize($this->limit);//->toXML();
        }

        if( is_null($this->products) ) {
            return false;
        }

        //return $this->products;

        $head = '<?xml version="1.0"?>';
        $xml = null;
        foreach($this->products as $_product)
        {
            if(is_null($xml)) {
                $xml = $head. '<product>
                    <entity_id>' . $_product->getEntity_id() . '</entity_id>
                    <entity_type_id>' . $_product->getEntity_type_id() . '</entity_type_id>
                    <attribute_set_id>' . $_product->getAttribute_set_id() . '</attribute_set_id>
                    <type_id>' . $_product->getType_id() . '</type_id>
                    <sku>' . $_product->getSku() . '</sku>
                    <has_options>' . $_product->getHas_options() . '</has_options>
                    <required_options>' . $_product->getRequired_options() . '</required_options>
                    <created_at>' . $_product->getCreated_at() . '</created_at>
                    <updated_at>' . $_product->getUpdated_at() . '</updated_at>
                  </product>';
            }else{
                $xml = $xml. '<product>
                    <entity_id>' . $_product->getEntity_id() . '</entity_id>
                    <entity_type_id>' . $_product->getEntity_type_id() . '</entity_type_id>
                    <attribute_set_id>' . $_product->getAttribute_set_id() . '</attribute_set_id>
                    <type_id>' . $_product->getType_id() . '</type_id>
                    <sku>' . $_product->getSku() . '</sku>
                    <has_options>' . $_product->getHas_options() . '</has_options>
                    <required_options>' . $_product->getRequired_options() . '</required_options>
                    <created_at>' . $_product->getCreated_at() . '</created_at>
                    <updated_at>' . $_product->getUpdated_at() . '</updated_at>
                  </product>';
            }
        }
        return $xml;
    }
}