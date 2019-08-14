<?php

class Studio45_Signifymap_Model_Mysql4_Signifymap_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{

    public function _construct()
    {
        parent::_construct();
        $this->_init('signifymap/signifymap');
    }

}
