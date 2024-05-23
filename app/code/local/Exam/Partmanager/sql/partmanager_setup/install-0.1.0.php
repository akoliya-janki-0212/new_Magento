<?php
$installer = $this;
$installer->startSetup();

$table = $installer->getConnection()
    ->newTable($installer->getTable('exam_partmanager/mfr'))
    ->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, [
        'identity' => true,
        'nullable' => false,
        'primary'  => true,
        'unsigned' => true,
    ], 'ID')
    ->addColumn('mfr', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, [
        'nullable' => false,
    ], 'Manufacturer')
    ->addColumn('address', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, [
        'nullable' => false,
    ], 'Address')
    ->addColumn('city', Varien_Db_Ddl_Table::TYPE_VARCHAR, 100, [
        'nullable' => false,
    ], 'City')
    ->addColumn('state', Varien_Db_Ddl_Table::TYPE_VARCHAR, 100, [
        'nullable' => false,
    ], 'State')
    ->addColumn('country', Varien_Db_Ddl_Table::TYPE_VARCHAR, 100, [
        'nullable' => false,
    ], 'Country')
    ->addColumn('is_active', Varien_Db_Ddl_Table::TYPE_TINYINT, null, [
        'nullable' => false,
        'default'  => '1',
    ], 'Is Active')
    ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, [
        'nullable' => false,
        'default'  => Varien_Db_Ddl_Table::TIMESTAMP_INIT,
    ], 'Created At')
    ->addColumn('updated_date', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, [
        'nullable' => false,
        'default'  => Varien_Db_Ddl_Table::TIMESTAMP_INIT_UPDATE,
    ], 'Updated Date')
    ->setComment('MFR Table');

$installer->getConnection()->createTable($table);

$installer->endSetup();