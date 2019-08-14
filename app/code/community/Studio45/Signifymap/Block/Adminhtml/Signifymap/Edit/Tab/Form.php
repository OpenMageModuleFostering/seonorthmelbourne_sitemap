<?php

class Studio45_Signifymap_Block_Adminhtml_Signifymap_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{

    protected function _prepareForm()
    {
        $signifymap = Mage::getModel('signifymap/signifymap');
        $row = $signifymap->getRow();
		if($row==null){
		$row=array("google"=>"","bing"=>"","window"=>"","yahoo"=>"","ping_interval"=>"","format"=>"");
		}

        $google = false;
        $bing = false;
        $window = false;
        $yahoo = false;

        if ($row['google'] == 'yes')
            $google = true;
        if ($row['bing'] == 'yes')
            $bing = true;
        if ($row['window'] == 'yes')
            $window = true;
        if ($row['yahoo'] == 'yes')
            $yahoo = true;

        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('signifymap_form', array('legend' => Mage::helper('signifymap')->__('Site Map')));

        if ($row['ping_interval'] != '') {
            $fieldset->addField('ping_interval', 'text', array(
                'label' => Mage::helper('signifymap')->__('Time Interval'),
                'class' => 'validate-greater-than-zero validate-digits',
                'required' => true,
                'name' => 'ping_interval',
                'value' => "" . $row['ping_interval'] . "",
                'after_element_html' => '<large>Please enter a valid number in this field. like .: 9</large>',
                ));
        } else {
            $fieldset->addField('ping_interval', 'text', array(
                'label' => Mage::helper('signifymap')->__('Time Interval'),
                'class' => 'validate-greater-than-zero validate-digits',
                'required' => true,
                'name' => 'ping_interval',
                'value' => '9',
                'after_element_html' => '<large>Please enter a valid number in this field. like .: 9</large>',
                ));
        }
        
        if ($row['format'] == 'hours') {
            $fieldset->addField('format', 'select', array(
                'name' => 'format',
                'align' => 'left',
                'values' => array(
                    array(
                        'value' => 'hours',
                        'label' => Mage::helper('signifymap')->__('Hour(s)')),
                    array(
                        'value' => 'days',
                        'label' => Mage::helper('signifymap')->__('Day(s)'),),
                    array(
                        'value' => 'weeks',
                        'label' => Mage::helper('signifymap')->__('Week(s)'),),
                    array(
                        'value' => 'months',
                        'label' => Mage::helper('signifymap')->__('Month(s)'),),
            )));
        }
        else if ($row['format'] == 'days') { 
            $fieldset->addField('format', 'select', array(
                'name' => 'format',
                'align' => 'left',
                'values' => array(
                    array(
                        'value' => 'days',
                        'label' => Mage::helper('signifymap')->__('Day(s)')),
                    array(
                        'value' => 'hours',
                        'label' => Mage::helper('signifymap')->__('Hour(s)'),),
                    array(
                        'value' => 'weeks',
                        'label' => Mage::helper('signifymap')->__('Week(s)'),),
                    array(
                        'value' => 'months',
                        'label' => Mage::helper('signifymap')->__('Month(s)'),),
            )));
        }
        else if ($row['format'] == 'weeks') {
            $fieldset->addField('format', 'select', array(
                'name' => 'format',
                'align' => 'left',
                'values' => array(
                    array(
                        'value' => 'weeks',
                        'label' => Mage::helper('signifymap')->__('Week(s)')),
                    array(
                        'value' => 'hours',
                        'label' => Mage::helper('signifymap')->__('Hour(s)'),),
                    array(
                        'value' => 'days',
                        'label' => Mage::helper('signifymap')->__('Day(s)'),),
                    array(
                        'value' => 'months',
                        'label' => Mage::helper('signifymap')->__('Month(s)'),),
            )));
        }
        else if ($row['format'] == 'months') {
            $fieldset->addField('format', 'select', array(
                'name' => 'format',
                'align' => 'left',
                'values' => array(
                    array(
                        'value' => 'months',
                        'label' => Mage::helper('signifymap')->__('Month(s)')),
                    array(
                        'value' => 'hours',
                        'label' => Mage::helper('signifymap')->__('Hour(s)'),),
                    array(
                        'value' => 'days',
                        'label' => Mage::helper('signifymap')->__('Day(s)'),),
                    array(
                        'value' => 'weeks',
                        'label' => Mage::helper('signifymap')->__('Week(s)'),),
            )));
        } else {
            $fieldset->addField('format', 'select', array(
                'name' => 'format',
                'align' => 'left',
                'values' => array(
                    array(
                        'value' => 'hours',
                        'label' => Mage::helper('signifymap')->__('Hour(s)'),
                        ),
                    array(
                        'value' => 'days',
                        'label' => Mage::helper('signifymap')->__('Day(s)'),
                        ),
                    array(
                        'value' => 'weeks',
                        'label' => Mage::helper('signifymap')->__('Week(s)'),
                        ),
                    array(
                        'value' => 'months',
                        'label' => Mage::helper('signifymap')->__('Month(s)')
                        )
                    )
                ));
        }

        $fieldset->addField('google', 'checkbox', array(
            'label' => Mage::helper('signifymap')->__('Choose Search Engine'),
            'name' => 'google',
            'checked' => $google,
            'onclick' => "",
            'onchange' => "",
            'value' => 'yes',
            'disabled' => false,
            'after_element_html' => '<large>Google Webmasters</large>',
            'tabindex' => 1
        ));

        $fieldset->addField('bing', 'checkbox', array(
            'name' => 'bing',
            'checked' => $bing,
            'onclick' => "",
            'onchange' => "",
            'value' => 'yes',
            'disabled' => false,
            'after_element_html' => '<large>Bing Webmasters</large>',
            'tabindex' => 1
        ));

        // $fieldset->addField('window', 'checkbox', array(
        //     'name' => 'window',
        //     'checked' => $window,
        //     'onclick' => "",
        //     'onchange' => "",
        //     'value' => 'yes',
        //     'disabled' => false,
        //     'after_element_html' => '<large>Window Live</large>',
        //     'tabindex' => 1
        // ));

        // $fieldset->addField('yahoo', 'checkbox', array(
        //     'name' => 'yahoo',
        //     'checked' => $yahoo,
            /* 'onclick' => "if(this.value=='yes'){if(this.checked==true){
              document.getElementById('yahoo_appid').style.visibility='visible';
              document.getElementById('label').style.visibility='visible';}
              else{
              document.getElementById('yahoo_appid').style.visibility='hidden';
              document.getElementById('label').style.visibility='hidden';
              }}", */
        //     'onchange' => "",
        //     'value' => 'yes',
        //     'disabled' => false,
        //     'after_element_html' => '<large>Yahoo</large>',
        //     'tabindex' => 1
        // ));


        /* $fieldset->addField('label', 'label', array(
          'after_element_html' => '<div id ="label" style=visibility:hidden;>Yahoo App Id</div>'));

          $fieldset->addField('yahoo_appid', 'text', array(
          'label'     => Mage::helper('signifymap')->__(''),
          'label_style' =>  'visibility: hidden;',
          'name'      => 'yahoo_id',
          'value'	  => ''.$yahoo_id.'',
          'style'     => 'visibility: hidden;')); */


        return parent::_prepareForm();
    }

}
