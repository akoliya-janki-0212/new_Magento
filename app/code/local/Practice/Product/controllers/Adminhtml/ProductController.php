<?php
class Practice_Product_Adminhtml_ProductController extends Mage_Adminhtml_Controller_Action{
    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        $this->loadLayout()
            ->_setActiveMenu('practice_product/product');
        return $this;
    }
    public function indexAction(){
        $this->_title($this->__('Manage_Product'));
        $this->_initAction();
        $this->renderLayout();
    }
}