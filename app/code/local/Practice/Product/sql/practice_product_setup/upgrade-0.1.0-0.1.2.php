<?php
$installer = $this;
$installer->startSetup();
// print_r($installer->getTable('practice_product/product'));

// Table name
$tableName = $installer->getTable('practice_product/product');

// Check if the table already has the column to avoid duplicate errors
if (!$installer->getConnection()->tableColumnExists($tableName, 'price')) {
    $installer->getConnection()
        ->addColumn(
            $tableName,
            'price',
            [
                'type'      => Varien_Db_Ddl_Table::TYPE_INTEGER,
                'nullable'  => true,
                'comment'   => 'New Column'
            ]
        );
}

$installer->endSetup();