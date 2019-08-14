<?php

class Studio45_Signifyresponse_Model_Signifyresponse extends Mage_Core_Model_Abstract
{

    public function _construct()
    {
        parent::_construct();
        $this->_init('signifyresponse/signifyresponse');
    }

    public function getRow()
    {
        $RowCollection = $this->getCollection()
                ->setOrder('signifyresponse_id', 'DESC');
        $row = $RowCollection->getFirstItem()->getData();
        return $row;
    }

}
