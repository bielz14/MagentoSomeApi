<?php
class CoolVendor_SomeApi_Model_Birrers extends Mage_Core_Model_Abstract {

    public function _construct()
    {
        parent::_construct();
        $this->_init('coolvendorsomeapi/birrers');
    }
}
