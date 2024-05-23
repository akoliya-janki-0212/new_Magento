<?php
class Exam_Partmanager_Block_Adminhtml_Manager extends Mage_Adminhtml_Block_Template
{
    public function __construct()
    {
        parent::__construct();
        //    $this->setTemplate('exam/manager.phtml');
    }
    public function getProduct()
    {
       return Mage::getModel('catalog/product')
            ->getCollection()
            ->addAttributeToFilter('part_number', array('notnull' => true));
    }
    public function getOption()
    {
        $options = [];
        $collection = $this->getProduct();
        foreach ($collection as $info) {
            $productId = $info['entity_id'];
            $product = Mage::getModel('catalog/product')->load($productId);
            $productName = $product->getName();
            $sku=$product->getSku();
            $options[] = array(
                'value' => $productId,
                'label' => $productName. ',' .$sku,
            );
        }
        return $options;
    }

}
?>