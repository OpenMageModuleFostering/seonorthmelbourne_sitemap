<?php

class Studio45_Signifyresponse_Block_Adminhtml_Signifyresponse extends Mage_Adminhtml_Block_Widget_Grid_Container
{

    public function __construct()
    {
        $this->_controller = 'adminhtml_signifyresponse';
        $this->_blockGroup = 'signifyresponse';
        $this->_headerText = Mage::helper('signifyresponse')->__('View Logs');
        parent::__construct();
        $this->removeButton('add');
    }

}
