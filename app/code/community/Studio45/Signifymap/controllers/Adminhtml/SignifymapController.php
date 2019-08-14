<?php

class Studio45_Signifymap_Adminhtml_SignifymapController extends Mage_Adminhtml_Controller_Action
{

    public function indexAction()
    {
        if (Mage::getModel('signifymap/signifymap')->generateSitemapXML())
            $this->_forward('edit');
        else
            $this->_redirect('*/*/config');
    }

    public function editAction()
    {
        $this->loadLayout();
        $this->_setActiveMenu('signifymap/items');

        $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
        $this->_addContent($this->getLayout()->createBlock('signifymap/adminhtml_signifymap_edit'))
                ->_addLeft($this->getLayout()->createBlock('signifymap/adminhtml_signifymap_edit_tabs'));

        $this->renderLayout();
    }

    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost()) {
            $model = Mage::getModel('signifymap/signifymap');
            $model->submitSitemap($data);
            $model->setData($data)
                    ->save();

            $model->changeInterval();
        }
        $this->_redirect('*/*/');
    }

    public function configAction()
    {
        $this->loadLayout();
        $this->_setActiveMenu('signifymap/items');

        $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

        $this->_addLeft($this->getLayout()->createBlock('signifymap/adminhtml_signifymap_edit_config'));

        if ($data = $this->getRequest()->getPost()) {
            $model = Mage::getModel('signifymap/config');
            $data['configured'] = 1;
            $model->setData($data)
                    ->save();
            Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('signifymap')->__('Sitemap was successfully configured'));
            $this->_redirect('*/*/config');
        }
        $this->renderLayout();
    }

}
