<?php
class Practice_Product_Model_Resource_Product extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('practice_product/product', 'product_id');
    }
}