<?php
$installer = $this;
$installer->startSetup();

$installer->addAttribute('catalog_product', 'sold_count', array(
    'group' => 'General',
    'type' => 'int',
    'backend' => '',
    'frontend' => '',
    'label' => 'Sold Count',
    'input' => 'text',
    'class' => '',
    'source' => '',
    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
    'visible' => true,
    'required' => false,
    'user_defined' => true,
    'default' => '',
    'searchable' => false,
    'filterable' => false,
    'comparable' => false,
    'visible_on_front' => false,
    'unique' => false,
    // 'note' => 'Semicolon-separated values',
)
);

$installer->endSetup();
