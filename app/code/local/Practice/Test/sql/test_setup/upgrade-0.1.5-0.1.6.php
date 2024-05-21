<?php
$installer = $this;
$installer->startSetup();

$attributeCode = 'test';
$optionsToRemove = array('test1_11');

$attribute = Mage::getSingleton('eav/config')->getAttribute('catalog_product', $attributeCode);

if ($attribute->getId()) {
    $options = $attribute->getSource()->getAllOptions(false);
    $optionsToDelete = array();
    foreach ($options as $option) {
        if (in_array($option['label'], $optionsToRemove)) {
            $optionsToDelete['delete'][$option['value']] = true;
            $optionsToDelete['value'][$option['value']] = true;
        }
    }

    // Debugging: Log options to delete
    Mage::log($optionsToDelete, null, 'attribute_option_deletion.log');

    if (!empty($optionsToDelete)) {
        $setup = new Mage_Eav_Model_Entity_Setup('core_setup');
        $setup->addAttributeOption($optionsToDelete);

        // Check if options were deleted
        $newOptions = $attribute->getSource()->getAllOptions(false);
        Mage::log($newOptions, null, 'attribute_option_after_deletion.log');
    }
}

$installer->endSetup();
