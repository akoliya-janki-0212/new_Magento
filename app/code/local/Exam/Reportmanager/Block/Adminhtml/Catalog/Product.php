<?php

class Exam_Reportmanager_Block_Adminhtml_Catalog_Product extends Mage_Adminhtml_Block_Catalog_Product
{
    protected function _prepareLayout()
    {
        $this->_addButton('save_report', array(
            'label' => Mage::helper('catalog')->__('Save Report'),
            'onclick' => 'productGridJsObject.saveReport()',
            'class' => 'save_report'
        )
        );
        parent::_prepareLayout();
    }

}