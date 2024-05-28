<?php
class Exam_Reportmanager_Block_Adminhtml_Customer extends Mage_Adminhtml_Block_Customer
{
    protected function _prepareLayout()
    {
        $this->_addButton('save_report', array(
            'label' => Mage::helper('catalog')->__('Save Report'),
            'onclick' => 'customerGridJsObject.saveReport()',
            'class' => 'save_report'
        )
        );
        parent::_prepareLayout();
    }

}