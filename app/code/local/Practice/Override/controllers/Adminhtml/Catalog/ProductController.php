<?php

require_once 'Mage\Adminhtml\controllers\Catalog\ProductController.php';

class Practice_Override_Adminhtml_Catalog_ProductController extends Mage_Adminhtml_Catalog_ProductController
{

    protected function _isAllowed()
    {
        parent::_isAllowed();
        $action = strtolower($this->getRequest()->getActionName());
        switch ($action) {
            case 'edit':
                $aclResource = 'catalog/products/edit';
                break;
            case 'delete':
                $aclResource = 'catalog/products/delete';
                break;
            case 'index':
                $aclResource = 'catalog/products/index';
                break;

            default:
                $aclResource = 'catalog/products';
                break;
        }
        return Mage::getSingleton('admin/session')->isAllowed($aclResource);
    }

}