<?php
//add attribute for product
$installer = $this;
$installer->startSetup();

$attributeCode = 'test';
$attributeLabel = 'Test1';

$data = array(
    'attribute_code' => $attributeCode,
    'type' => 'int', // Correct key for backend_type
    'input' => 'select', // Correct key for frontend_input
    'label' => $attributeLabel, // Simplified label key
    'source' => 'eav/entity_attribute_source_table', // Ensure that the source model exists and is correctly specified
    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
    'required' => false,
    'configurable' => false,
    'visible_on_front' => true,
    'searchable' => false,
    'filterable' => false,
    'comparable' => false,
    'used_for_promo_rules' => false,
    'is_html_allowed_on_front' => true,
    'option' => array(
        'value' => array(
            'option1' => array(0 => 'test1_11'),
            'option2' => array(0 => 'test1_22')
        )
    )
);

$installer->addAttribute('catalog_product', $attributeCode, $data);
$installer->endSetup();

