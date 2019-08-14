<?php

class Studio45_Signifymap_Block_Adminhtml_Signifymap extends Mage_Adminhtml_Block_Widget_Grid_Container
{

    public function __construct()
    {
        $this->_controller = 'adminhtml_signifymap';
        $this->_blockGroup = 'signifymap';
        $this->_headerText = Mage::helper('signifymap')->__('sitemap');
        $this->_addButtonLabel = Mage::helper('signifymap')->__('site map');
        parent::__construct();
    }

}
