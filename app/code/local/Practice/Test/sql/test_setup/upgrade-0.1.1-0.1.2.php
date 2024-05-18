<?php
ini_set('display_errors', '1');

$installer = $this;
$installer->startSetup();
$installer->getConnection()
    ->addColumn(
        $installer->getTable('practice_test/test1'), //Get the newsletter Table
        'status', //New Field Name
        array(
            'type' => Varien_Db_Ddl_Table::TYPE_TEXT, 64, //Field Type like TYPE_INTEGER ...
            'nullable' => true,
            'length' => 255,
            'comment' => 'add status column'
        )
    );
$installer->endSetup();
?>