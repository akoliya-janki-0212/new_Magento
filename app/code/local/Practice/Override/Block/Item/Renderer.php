<?php

class Practice_Override_Block_Item_Renderer extends Mage_Checkout_Block_Cart_Item_Renderer
{
    public function getDemoTest($brandId) {
        return Mage::getModel('catalog/product')->getResource()->getAttribute('brand')->getSource()->getOptionText($brandId);
    }
}