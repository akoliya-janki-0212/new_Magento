<?php

class Practice_Override_Block_Item_Grouped extends Mage_Checkout_Block_Cart_Item_Renderer_Grouped
{
    public function getDemoTest($brandId) {
        return Mage::getModel('catalog/product')->getResource()->getAttribute('brand')->getSource()->getOptionText($brandId);
    }
}