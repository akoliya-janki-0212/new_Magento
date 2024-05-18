<?php 
class Practice_Override_Block_Adminhtml_Catalog_Product_Grid extends Mage_Adminhtml_Block_Catalog_Product_Grid
{

    public function getRowUrl($row){

        if (Mage::getSingleton('admin/session')->isAllowed('catalog/products/edit')) {
            return $this->getUrl('*/*/edit', array(
                'store'=>$this->getRequest()->getParam('store'),
                'id'=>$row->getId())
            );
        }
        return '#';
    }

}