<?php

class Studio45_Signifyresponse_Model_Mysql4_Signifyresponse extends Mage_Core_Model_Mysql4_Abstract
{

    public function _construct()
    {
        // Note that the signifyresponse_id refers to the key field in your database table.
        $this->_init('signifyresponse/signifyresponse', 'signifyresponse_id');
    }

}
