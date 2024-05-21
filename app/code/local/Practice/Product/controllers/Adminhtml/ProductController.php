<?php
class Practice_Product_Adminhtml_ProductController extends Mage_Adminhtml_Controller_Action
{
    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        $this->loadLayout()
            ->_setActiveMenu('practice_product/product');
        return $this;
    }
    public function indexAction()
    {
        $this->_title($this->__('Manage_Product'));
        $this->_initAction();
        $this->renderLayout();
    }
    protected function newAction()
    {
        $this->_forward('edit');
    }
    protected function editAction()
    {
        $this->_title($this->__('practice_product'))->_title($this->__('Product'));
        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('product_id');
        $model = Mage::getModel('practice_product/product');

        // 2. Initial checking
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                Mage::getSingleton('adminhtml/session')->
                    addError(Mage::helper('practice_product')->
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
        Mage::register('product_registry', $model);
        // 5. Build edit form

        $this->_initAction()
            ->_addBreadcrumb($id ? Mage::helper('practice_product')->__('Edit Banner') : Mage::helper('practice_product')->__('New Banner'), $id ? Mage::helper('practice_product')->__('Edit Banner') : Mage::helper('practice_product')->__('New Banner'));
        $this->renderLayout();
    }
    protected function saveAction(){
        if ($data = $this->getRequest()->getParams()) {
            // Initialize model and set data
            $model = Mage::getModel('practice_product/product');
            if ($id = $this->getRequest()->getParam('product_id')) {
                $model->load($id);
            }
            // Set other data
            $model->setData($data);
            try {
                // Save the data
                $model->save();
                // Display success message
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('practice_product')->__('The Product has been saved.')
                );
                // Clear previously saved data from session
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                // Check if 'Save and Continue'
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('banner_id' => $model->getId(), '_current' => true));
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
                    Mage::helper('product_product')->__('An error occurred while saving the product.')
                );
            }

            // Set form data
            $this->_getSession()->setFormData($data);
            $this->_redirect('*/*/edit', array('product_id' => $this->getRequest()->getParam('product_id')));
            return;
        }
        $this->_redirect('*/*/');
    }
    public function deleteAction()
    {
        // check if we know what should be deleted
        if ($id = $this->getRequest()->getParam('product_id')) {
            $title = "";
            try {
                // init model and delete
                $model = Mage::getModel('practice_product/product');
                $model->load($id);
                $title = $model->getTitle();
                $model->delete();
                // display success message
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('practice_product')->__('The product has been deleted.')
                );
                $this->_redirect('*/*/');
                return;
            } catch (Exception $e) {
                // display error message
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                // go back to edit form
                $this->_redirect('*/*/edit', array('product_id' => $id));
                return;
            }
        }
        // display error message
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('practice_product')->__('Unable to find a product to delete.'));
        // go to grid
        $this->_redirect('*/*/');
    }
    public function massDeleteAction()
    {
        $entityIds = $this->getRequest()->getParam('ids'); // Get selected entity IDs
        if (!is_array($entityIds)) {
            $this->_getSession()->addError($this->__('Please select item(s).'));
        } else {
            try {
                foreach ($entityIds as $entityId) {
                    // Perform delete operation for each selected item
                    Mage::getModel('practice_product/product')->load($entityId)->delete();
                }
                $this->_getSession()->addSuccess($this->__('Total of %d record(s) were deleted.', count($entityIds)));
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
}