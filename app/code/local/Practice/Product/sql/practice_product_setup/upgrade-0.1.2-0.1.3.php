<?php
$installer = $this;
$installer->startSetup();

// Create table 'practice_product'
$table = $installer->getConnection()
    ->newTable($installer->getTable('practice_product/category'))
    ->addColumn('catenory_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity' => true,
        'unsigned' => true,
        'nullable' => false,
        'primary' => true,
    ), 'Product ID')
    ->addColumn('category_name', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable' => false,
    ), 'Product Name')
    ->addColumn('product_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned' => true,
        'nullable' => false,
    ), 'Product ID')
    ->addIndex(
        $installer->getIdxName('practice_product/category', array('product_id')),
        array('product_id')
    )
    ->addForeignKey(
        $installer->getFkName('practice_product/category', 'product_id', 'practice_product/product', 'product_id'),
        'product_id',
        $installer->getTable('practice_product/product'),
        'product_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE,
        Varien_Db_Ddl_Table::ACTION_CASCADE
    )
    ->setComment('Practice Product Table');

$installer->getConnection()->createTable($table);

$installer->endSetup();