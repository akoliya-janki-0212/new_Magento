<?php
class Ccc_Outlook_Adminhtml_OutlookController extends Mage_Adminhtml_Controller_Action
{
    protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('ccc_outlook/outlook');
        return $this;
    }
    public function indexAction()
    {
        $this->_title($this->__('Manage_Outlook'));
        $this->_initAction();
        $this->renderLayout();
    }
    protected function newAction()
    {
        $this->_forward('edit');
    }
    protected function editAction()
    {
        $this->_title($this->__('ccc_outlook'))->_title($this->__('Outlook'));
        $id = $this->getRequest()->getParam('configuration_id');
        $model = Mage::getModel('ccc_outlook/configuration');
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                Mage::getSingleton('adminhtml/session')->
                    addError(Mage::helper('ccc_outlook')->
                        __('This outlook no longer exists.'));
                $this->_redirect('*/*/');
                return;
            }
        }
        $this->_title($model->getId() ? $model->getTitle() : $this->__('New Outlook'));
        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }
        Mage::register('configuration_model', $model);
        $this->_initAction()
            ->_addBreadcrumb($id ? Mage::helper('ccc_outlook')->__('Edit Outlook') : Mage::helper('ccc_outlook')->__('New Outlook'), $id ? Mage::helper('ccc_outlook')->__('Edit Outlook') : Mage::helper('ccc_outlook')->__('New Outlook'));
        $this->renderLayout();
    }
    protected function saveAction()
    {
        if ($data = $this->getRequest()->getParams()) {
            $model = Mage::getModel('ccc_outlook/configuration');
            if ($id = $this->getRequest()->getParam('configuration_id')) {
                $model->load($id);
            }
            $model->setData($data);
            try {
                 $model->save();
               Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('ccc_outlook')->__('The Configuration has been saved.')
                );
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('configuration_id' => $model->getId(), '_current' => true));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            } catch (Exception $e) {
                $this->_getSession()->addException(
                    $e,
                    Mage::helper('ccc_outlook')->__('An error occurred while saving the Configuration.')
                );
            }
            $this->_getSession()->setFormData($data);
            $this->_redirect('*/*/edit', array('configuration_id' => $this->getRequest()->getParam('configuration_id')));
            return;
        }
        $this->_redirect('*/*/');
    }
}