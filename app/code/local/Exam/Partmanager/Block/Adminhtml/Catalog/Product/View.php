<?php
class Exam_Partmanager_Block_Adminhtml_Catalog_Product_View extends Mage_Catalog_Block_Product_Abstract
{
    public function getProductPartDetails()
    {
        $collection = Mage::getModel('exam_partmanager/mfr')
            ->getCollection()
            ->addFieldToSelect('mfr')
            ->addFieldToSelect('address');
        $collection->getSelect()->join(
            array('parts' => $collection->getTable('exam_partmanager/parts')),
            'main_table.mfr_id = parts.mfr_id',
            array('avg_qty' => new Zend_Db_Expr('AVG(parts.part_qty)'))
        )->where('parts.product_id = ?', $this->getProduct()->getId())
            ->group('main_table.mfr_id');
        return $collection;
    }
}