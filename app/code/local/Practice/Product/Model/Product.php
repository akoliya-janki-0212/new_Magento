<?php
class Practice_Product_Model_Product extends Mage_Core_Model_Abstract
{
    protected $_eventPrefix = 'practice_product';
    protected $_eventObject = 'product';
    protected function _construct()
    {
        $this->_init('practice_product/product');
    }
}
