<?php
class CoolVendor_SomeApi_Model_Resource_Birrers extends Mage_Core_Model_Mysql4_Abstract {

    public function _construct()
    {
        $this->_init('coolvendorsomeapi/table_birrers','id');
    }

}