<?php

class Studio45_Signifymap_Block_Adminhtml_Signifymap_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{

    public function __construct()
    {
        parent::__construct();

        $this->_objectId = 'id';
        $this->_blockGroup = 'signifymap';
        $this->_controller = 'adminhtml_signifymap';

        $this->_updateButton('save', 'label', Mage::helper('signifymap')->__('Save'));

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('signifymap_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'signifymap_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'signifymap_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if (Mage::registry('signifymap_data') && Mage::registry('signifymap_data')->getId()) {
            return Mage::helper('signifymap')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('signifymap_data')->getTitle()));
        } else {
            return Mage::helper('signifymap')->__('Site Map');
        }
    }

}
