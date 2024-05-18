<?php
class Practice_Override_Model_Catalog_Product extends Mage_Catalog_Model_Product
{
    public function getName()
    {
        $name = parent::getName();
        return $name . '  Janki';
    }
}
?>