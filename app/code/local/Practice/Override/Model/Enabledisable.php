<?php

class Practice_Override_Model_Enabledisable
{
    public function toOptionArray()
    {
        return array(
            array('value' =>0, 'label' => Mage::helper('adminhtml')->__('Enable')),
            array('value' => 1, 'label' => Mage::helper('adminhtml')->__('Disable')),
        );
    }
}
