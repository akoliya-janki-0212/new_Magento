<?php
class Practice_Override_Block_Adminhtml_Catalog_Product_Edit extends Mage_Adminhtml_Block_Catalog_Product_Edit
{
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        if (!Mage::getSingleton('admin/session')->isAllowed('catalog/products/delete')) {
            $this->unsetChild('delete_button');
        }
    }
}