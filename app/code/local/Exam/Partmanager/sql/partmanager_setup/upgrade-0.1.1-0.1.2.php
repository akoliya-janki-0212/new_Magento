
<?php
$installer = $this;
$installer->startSetup();

$table2 = $installer->getConnection()
    ->newTable($installer->getTable('exam_partmanager/parts'))
    ->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, [
        'identity' => true,
        'nullable' => false,
        'primary'  => true,
        'unsigned' => true,
    ], 'ID')
    ->addColumn('mfr_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, [
        'nullable' => false,
        'unsigned' => true,
    ], 'Manufacturer ID')
    ->addColumn('product_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, [
        'nullable' => false,
        'unsigned' => true,
    ], 'Product ID')
    ->addColumn('part_number', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, [
        'nullable' => false,
    ], 'Part Number')
    ->addColumn('part_qty', Varien_Db_Ddl_Table::TYPE_INTEGER, null, [
        'nullable' => false,
    ], 'Part Quantity')
    ->addColumn('average_product_qty', Varien_Db_Ddl_Table::TYPE_INTEGER, null, [
        'nullable' => false,
    ], 'Average Product Quantity')
    ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, [
        'nullable' => false,
        'default'  => Varien_Db_Ddl_Table::TIMESTAMP_INIT,
    ], 'Created At')
    ->addColumn('updated_date', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, [
        'nullable' => false,
        'default'  => Varien_Db_Ddl_Table::TIMESTAMP_INIT_UPDATE,
    ], 'Updated Date')
   
    ->setComment('CCC Manufacturer Parts');

$installer->getConnection()->createTable($table2);

$installer->endSetup();