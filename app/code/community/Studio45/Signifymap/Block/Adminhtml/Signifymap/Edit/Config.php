<?php

class Studio45_Signifymap_Block_Adminhtml_Signifymap_Edit_Config extends Mage_Adminhtml_Block_Widget_Tabs
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('signifymap_config');
        $this->setDestElementId('config_form');
        $this->setTitle(Mage::helper('signifymap')->__('Configuration'));
    }

    protected function _beforeToHtml()
    {
        $this->addTab('form_section', array(
            'label' => Mage::helper('signifymap')->__('Configuration'),
            'title' => Mage::helper('signifymap')->__('Sitemap'),
        ));

        return parent::_beforeToHtml();
    }

}
