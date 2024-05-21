<?php
$installer = $this;
$installer->startSetup();

$tableName = $installer->getTable('sales/quote_item');

$installer->getConnection()
    ->addColumn(
        $tableName,
        'brand',
        array(
            'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
            'length' => 11,
            'comment' => 'brand Id'
        )
    );

$installer->endSetup();
