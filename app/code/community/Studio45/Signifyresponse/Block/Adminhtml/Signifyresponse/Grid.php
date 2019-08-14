<?php

class Studio45_Signifyresponse_Block_Adminhtml_Signifyresponse_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('signifyresponseGrid');
        $this->setDefaultSort('signifyresponse_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('signifyresponse/signifyresponse')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('signifyresponse_id', array(
            'header' => Mage::helper('signifyresponse')->__('ID'),
            'align' => 'right',
            'width' => '10px',
            'index' => 'signifyresponse_id',
        ));

        $this->addColumn('google_response', array(
            'header' => Mage::helper('signifyresponse')->__('Google Webmasters Response'),
            'align' => 'left',
            'index' => 'google_response',
            'renderer' => 'signifyresponse/adminhtml_signifyresponse_description'
        ));

      
        $this->addColumn('bing_response', array(
            'header' => Mage::helper('signifyresponse')->__('Bing Webmasters Response'),
            'align' => 'left',
            'index' => 'bing_response',
            'renderer' => 'signifyresponse/adminhtml_signifyresponse_description'
        ));

        

        $this->addColumn('date', array(
            'header' => Mage::helper('signifyresponse')->__('Date'),
            'align' => 'left',
            'index' => 'date',
        ));



        return parent::_prepareColumns();
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('signifyresponse_id');
        $this->getMassactionBlock()->setFormFieldName('signifyresponse');

        $this->getMassactionBlock()->addItem('delete', array(
            'label' => Mage::helper('signifyresponse')->__('Delete'),
            'url' => $this->getUrl('*/*/massDelete'),
            'confirm' => Mage::helper('signifyresponse')->__('Are you sure?')
        ));


        return $this;
    }

    public function getRowUrl($row)
    {
        // return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

}
