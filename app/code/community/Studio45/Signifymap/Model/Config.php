<?php

class Studio45_Signifymap_Model_Config extends Mage_Core_Model_Abstract
{

    public function _construct()
    {
        parent::_construct();
        $this->_init('signifymap/config');
    }

    public function getRow()
    {
        $collection = $this->getCollection()
                ->setOrder('id', 'DESC');
        $row = $collection->getFirstItem()->getData();
        return $row;
    }

}
