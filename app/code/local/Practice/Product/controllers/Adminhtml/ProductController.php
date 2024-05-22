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

        $id = $this->getRequest()->getParam('product_id');
        $modelProduct = Mage::getModel('practice_product/product');
        $modelCategory = Mage::getModel('practice_product/category');

        if ($id) {
            $modelProduct->load($id);
            $modelCategory->load($id);
            if (!$modelProduct->getId()) {
                Mage::getSingleton('adminhtml/session')->
                    addError(Mage::helper('practice_product')->
                        __('This product no longer exists.'));
                $this->_redirect('*/*/');
                return;
            }
        }

        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
        if (!empty($data)) {
            $modelProduct->setData($data);
            $modelCategory->setData($data);
        }
        Mage::register('practice_product', $modelProduct);
        Mage::register('practice_category', $modelCategory);


        $this->_initAction()
            ->_addBreadcrumb($id ? Mage::helper('practice_product')->__('Edit Banner') : Mage::helper('practice_product')->__('New Banner'), $id ? Mage::helper('practice_product')->__('Edit Banner') : Mage::helper('practice_product')->__('New Banner'));
        $this->renderLayout();
    }
    protected function saveAction()
    {
        if ($data = $this->getRequest()->getParams()) {
            // Initialize model and set data
            $modelProduct = Mage::getModel('practice_product/product');
            $modelCategory = Mage::getModel('practice_product/category');
            if ($id = $this->getRequest()->getParam('product_id')) {
                $modelProduct->load($id);
                $modelCategory->load($id);
            }
            // Set other data
            $modelProduct->setData($data);
            $modelCategory->setData($data);
            try {
                // Save the data
                $modelProduct->save();
                $modelCategory->save();
                // die;
                // Display success message
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('practice_product')->__('The Product has been saved.')
                );
                // Clear previously saved data from session
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                // Check if 'Save and Continue'
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('product_id' => $modelProduct->getId(), '_current' => true));
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