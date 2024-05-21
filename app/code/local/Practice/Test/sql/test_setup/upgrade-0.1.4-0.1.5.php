<?php
$installer = $this;
$installer->startSetup();
$attributeCode = 'test';
$newOption = array('option3' => array(0 => 'test1_33'));
$attribute = Mage::getSingleton('eav/config')->getAttribute('catalog_product', $attributeCode);
if ($attribute->getId()) {
    $options = $attribute->getSource()->getAllOptions(false);
    $optionExists = false;
    foreach ($options as $option) {
        if (in_array('test1_33', $option)) {
            $optionExists = true;
            break;
        }
    }
    if (!$optionExists) {
        $option = array(
            'attribute_id' => $attribute->getId(),
            'value'        => $newOption
        );
        $setup = new Mage_Eav_Model_Entity_Setup('core_setup');
        $setup->addAttributeOption($option);
    }
}
$installer->endSetup();

