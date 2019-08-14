<?php

class Studio45_Signifyresponse_Adminhtml_SignifyresponseController extends Mage_Adminhtml_Controller_Action
{

    protected function _initAction()
    {
        $this->loadLayout()
                ->_setActiveMenu('signifymap/items');

        return $this;
    }

    public function indexAction()
    {
        $config = Mage::getModel('signifymap/config');
        $row = $config->getRow();
        if ($row['configured'] == 0)
            $this->_redirect('signifymap/adminhtml_signifymap/config');
        $this->_initAction()
                ->renderLayout();
    }

    public function deleteAction()
    {
        if ($this->getRequest()->getParam('id') > 0) {
            try {
                $model = Mage::getModel('signifyresponse/signifyresponse');
                $model->setId($this->getRequest()->getParam('id'))
                        ->delete();

                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Item was successfully deleted'));
                $this->_redirect('*/*/');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            }
        }
        $this->_redirect('*/*/');
    }

    public function massDeleteAction()
    {
        $signifyresponseIds = $this->getRequest()->getParam('signifyresponse');
        if (!is_array($signifyresponseIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
                foreach ($signifyresponseIds as $signifyresponseId) {
                    $signifyresponse = Mage::getModel('signifyresponse/signifyresponse')->load($signifyresponseId);
                    $signifyresponse->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                        Mage::helper('adminhtml')->__('Total of %d record(s) were successfully deleted', count($signifyresponseIds)));
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }

}
