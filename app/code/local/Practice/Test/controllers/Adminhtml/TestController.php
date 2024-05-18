<?php
class Practice_Test_Adminhtml_TestController extends Mage_Adminhtml_Controller_Action
{
    protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('practice_test/test');
        return $this;
    }
    public function indexAction()
    {
        Mage::dispatchEvent('before_test_add',array('name'=>'janki'));
        Mage::dispatchEvent('before_test_adds');
        // print_r(Mage::getStoreConfig('practice_test/settings/test1_name'));
        $this->_title($this->__('Test'));
        $this->_initAction();
        $this->renderLayout();
    }
    public function newAction()
    {
        $this->_forward('edit');
    }

    public function editAction()
    {

        $this->_title($this->__('Practice Test'))->_title($this->__('Practice Test'));

        $id = $this->getRequest()->getParam('test1_id');
        $model1 = Mage::getModel('practice_test/test1');
        $model2 = Mage::getModel('practice_test/test2');
        $model3 = Mage::getModel('practice_test/test3');

        if ($id) {
            $model1->load($id);
            $model2->load($id);
            $model3->load($id);
            if (!$model1->getId()) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('practice_test')->__('This banner no longer exists.'));
                $this->_redirect('*/*/');
                return;
            }
        }

        $this->_title($model1->getId() ? $model1->getTitle() : $this->__('New Test'));

        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
        if (!empty($data)) {
            $model1->setData($data);
            $model2->setData($data);
            $model3->setData($data);
        }

        Mage::register('practice_test1', $model1);
        Mage::register('practice_test2', $model2);
        Mage::register('practice_test3', $model3);

        $this->_initAction()
            ->_addBreadcrumb($id ? Mage::helper('practice_test')->__('Edit Test') : Mage::helper('practice_test')->__('Edit Test'), $id ? Mage::helper('practice_test')->__('Edit Test') : Mage::helper('practice_test')->__('Edit Test'));
        $this->renderLayout();
    }
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost()) {
            $model1 = Mage::getModel('practice_test/test1');
            $model2 = Mage::getModel('practice_test/test2');
            $model3 = Mage::getModel('practice_test/test3');
            if ($id = $this->getRequest()->getParam('test1_id')) {
                $model1->load($id);
                $model2->load($id);
                $model3->load($id);
            }

            $model1->setData($data);
            $model2->setData($data);
            $model3->setData($data);


            // try to save it
            try {
                // save the data
                $model1->save();
                $model2->save();
                $model3->save();

                // display success message
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('practice_test')->__('The page has been saved.')
                );
                // clear previously saved data from session
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                // check if 'Save and Continue'
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('test1_id' => $model1->getId(), '_current' => true));
                    return;
                }
                // go to grid
               $this->_redirect('*/*/');
                return;

            } catch (Mage_Core_Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            } catch (Exception $e) {
                $this->_getSession()->addException(
                    $e,
                    Mage::helper('practice_test')->__('An error occurred while saving the page.')
                );
            }

            $this->_getSession()->setFormData($data);
           $this->_redirect('*/*/edit', array('test1_id' => $this->getRequest()->getParam('test1_id')));
            return;
        }
        $this->_redirect('*/*/');
    }
    public function deleteAction()
    {
        // check if we know what should be deleted
        if ($id = $this->getRequest()->getParam('test1_id')) {
            $title = "";
            try {
                // init model and delete
                $model = Mage::getModel('practice_test/test1');
                $model->load($id);
                $title = $model->getTitle();
                $model->delete();

                $model1 = Mage::getModel('practice_test/test2');
                $model1->load($id);
                $title = $model1->getTitle();
                $model1->delete();

                $model2 = Mage::getModel('practice_test/test3');
                $model2->load($id);
                $title = $model2->getTitle();
                $model2->delete();
                // display success message
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('practice_test')->__('The page has been deleted.')
                );
                // go to grid
                Mage::dispatchEvent('adminhtml_cmspage_on_delete', array('title' => $title, 'status' => 'success'));
                $this->_redirect('*/*/');
                return;

            } catch (Exception $e) {
                Mage::dispatchEvent('adminhtml_cmspage_on_delete', array('title' => $title, 'status' => 'fail'));
                // display error message
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                // go back to edit form
                $this->_redirect('*/*/edit', array('test1_id' => $id));
                return;
            }
        }
        // display error message
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('practice_test')->__('Unable to find a page to delete.'));
        // go to grid
        $this->_redirect('*/*/');
    }
   
}