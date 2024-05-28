<?php
class Exam_Partmanager_Adminhtml_PartmanagerController extends Mage_Adminhtml_Controller_Action
{
    protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('exam_partmaneger/partmaneger');
        return $this;
    }
    public function indexAction()
    {
        $this->_title($this->__('Manage_MFR'));
        $this->_initAction();
        $this->renderLayout();
    }
    protected function newAction()
    {
        $this->_forward('edit');
    }
    protected function editAction()
    {
        $this->_title($this->__('exam_partmanager'))->_title($this->__('Mfr'));
        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('mfr_id');
        $model = Mage::getModel('exam_partmanager/mfr');

        // 2. Initial checking
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                Mage::getSingleton('adminhtml/session')->
                    addError(Mage::helper('exam_partmanager')->
                        __('This product no longer exists.'));
                $this->_redirect('*/*/');
                return;
            }
        }
        $this->_title($model->getId() ? $model->getTitle() : $this->__('New Banner'));

        // 3. Set entered data if was error when we do save
        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }

        // 4. Register model to use later in blocks
        Mage::register('mfr_registry', $model);
        // 5. Build edit form

        $this->_initAction()
            ->_addBreadcrumb($id ? Mage::helper('exam_partmanager')->__('Edit Banner') : Mage::helper('exam_partmanager')->__('New Banner'), $id ? Mage::helper('exam_partmanager')->__('Edit Banner') : Mage::helper('exam_partmanager')->__('New Banner'));
        $this->renderLayout();
    }
    protected function saveAction()
    {
        if ($data = $this->getRequest()->getParams()) {
            // Initialize model and set data
            $model = Mage::getModel('exam_partmanager/mfr');
            if ($id = $this->getRequest()->getParam('mfr_id')) {
                $model->load($id);
            }
            // Set other data
            $model->setData($data);
            try {
                // Save the data
                $model->save();
                // Display success message
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('exam_partmanager')->__('The Product has been saved.')
                );
                // Clear previously saved data from session
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                // Check if 'Save and Continue'
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('mfr_id' => $model->getId(), '_current' => true));
                    return;
                }
                // Go to grid
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            } catch (Exception $e) {
                $this->_getSession()->addException(
                    $e,
                    Mage::helper('exam_partmanager')->__('An error occurred while saving the product.')
                );
            }

            // Set form data
            $this->_getSession()->setFormData($data);
            $this->_redirect('*/*/edit', array('mfr_id' => $this->getRequest()->getParam('mfr_id')));
            return;
        }
        $this->_redirect('*/*/');
    }
    public function deleteAction()
    {
        // check if we know what should be deleted
        if ($id = $this->getRequest()->getParam('mfr_id')) {
            $title = "";
            try {
                // init model and delete
                $model = Mage::getModel('exam_partmanager/mfr');
                $model->load($id);
                $title = $model->getTitle();
                $model->delete();
                // display success message
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('exam_partmanager')->__('The product has been deleted.')
                );
                $this->_redirect('*/*/');
                return;
            } catch (Exception $e) {
                // display error message
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                // go back to edit form
                $this->_redirect('*/*/edit', array('mfr_id' => $id));
                return;
            }
        }
        // display error message
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('exam_partmanager')->__('Unable to find a product to delete.'));
        // go to grid
        $this->_redirect('*/*/');
    }
    public function massIsactiveAction()
    {
        $bannerIds = $this->getRequest()->getParam('mfr_id');
        $status = $this->getRequest()->getParam('is_active');

        if (!is_array($bannerIds)) {
            $bannerIds = array($bannerIds);
        }

        try {
            foreach ($bannerIds as $bannerId) {
                $banner = Mage::getModel('exam_partmanager/mfr')->load($bannerId);
                // Check if the status is different than the one being set
                if ($banner->getIsActive() != $status) {
                    $banner->setIsActive($status)->save();
                }
            }
            // Use appropriate success message based on the status changed
            if ($status == 1) {
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) have been enabled.', count($bannerIds))
                );
            } else {
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) have been disabled.', count($bannerIds))
                );
            }
        } catch (Exception $e) {
            $this->_getSession()->addError($e->getMessage());
        }

        $this->_redirect('*/*/index');
    }
    public function managerAction()
    {
        $this->_initAction();
        $this->renderLayout();
    }
    public function getDetailsAction()
    {
        $productId = $this->getRequest()->getPost('productId');
        $data = array();
        $product = Mage::getModel('catalog/product')->load($productId);
        if ($product->getId()) {
            $data['productDetails'] = array(
                'name' => $product->getName(),
                'sku' => $product->getSku(),
                'part_number' => $product->getData('part_number'),
            );
            $manufacturerParts = array();
            $manufacturers = Mage::getModel('exam_partmanager/mfr')->getCollection();

            // Iterate over each manufacturer
            foreach ($manufacturers as $manufacturer) {
                $manufacturerParts[$manufacturer->getMfr()] = $product->getData('part_number');
            }
            $data['manufacturerDetails'] = $manufacturerParts;
        }
        $this->getResponse()->setHeader('Content-type', 'application/json');
        $this->getResponse()->setBody(json_encode($data));
    }
    public function saveMfrPartsAction()
    {
        $productId = $this->getRequest()->getParam('productId');
        $manufacturerPartQuantitiesJson = $this->getRequest()->getParam('manufacturerPartQuantities');
        $manufacturerPartQuantities = json_decode($manufacturerPartQuantitiesJson, true);
        foreach ($manufacturerPartQuantities as $manufacturer => $parts) {
            $id = Mage::getModel('exam_partmanager/mfr')->getCollection()
                ->addFieldToFilter('mfr', $manufacturer)
                ->getFirstItem()
                ->getId();
            foreach ($parts as $partData) {
                $part = $partData['part'];
                $quantity = $partData['quantity'];
                $minQty = $partData['min_qty'];
                if (!empty($quantity)) {
                    $model = Mage::getModel('exam_partmanager/parts')
                        ->setProductId($productId)
                        ->setMfrId($id)
                        ->setPartNumber($part)
                        ->setPartQty($quantity)
                        ->setCreatedAt(now())
                        ->setUpdatedDate(now())
                        ->setAverageProductQty($minQty)
                        ->save();
                }
            }
        }
        $response = [
            'success' => true,
            'message' => 'Manufacturer part quantities saved successfully.'
        ];

        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($response));
    }

    protected function _isAllowed()
    {
        $action = strtolower($this->getRequest()->getActionName());
        $aclResource = '';
        switch ($action) {
            case 'manager':
                $aclResource = 'customer/partmanager/manager';
                break;
            case 'index':
                $aclResource = 'customer/partmanager/index';
                break;
            default:
                $aclResource = 'customer/partmanager';
        }
        return Mage::getSingleton('admin/session')->isAllowed($aclResource);
    }

}