<?php

class Studio45_Signifymap_Model_Mysql4_Signifymap extends Mage_Core_Model_Mysql4_Abstract
{

    public function _construct()
    {
        // Note that the signifymap_id refers to the key field in your database table.
        $this->_init('signifymap/signifymap', 'signifymap_id');
    }

}
