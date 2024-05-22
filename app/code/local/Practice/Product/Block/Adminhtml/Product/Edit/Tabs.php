<?php
class Practice_Product_Block_Adminhtml_Product_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('product_ids');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('practice_product')->__('Product Information'));
     
    }
}
