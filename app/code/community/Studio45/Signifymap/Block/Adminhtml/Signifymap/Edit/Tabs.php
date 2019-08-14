<?php

class Studio45_Signifymap_Block_Adminhtml_Signifymap_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('signifymap_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('signifymap')->__('Site Map'));
    }

    protected function _beforeToHtml()
    {
        $this->addTab('form_section', array(
            'label' => Mage::helper('signifymap')->__('Site Map'),
            //'title'     => Mage::helper('signifymap')->__('Item Information'),
            'content' => $this->getLayout()->createBlock('signifymap/adminhtml_signifymap_edit_tab_form')->toHtml(),
        ));

        return parent::_beforeToHtml();
    }

}
