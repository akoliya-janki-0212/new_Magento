<?php
class Practice_Override_Block_Catalog_Product_List extends Mage_Catalog_Block_Product_List
{
    protected function _getProductCollection()
    {
        $_collection = parent::_getProductCollection();
        $_collection->setPageSize(2); // Sort by product name in ascending order
        return $_collection;
    }
}
?>