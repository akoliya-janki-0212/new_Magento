<?php
$installer = $this;
$installer->startSetup();
$tableName = $installer->getTable('practice_product/product');
$data = [
    [
        'product_name' => 'Product j',
        'status' => 1,
        'created_at' => now(),
        'updated_at' => now(),
        'price' => '10.00'
    ],
    [
        'product_name' => 'Product k',
        'status' => 0,
        'created_at' => now(),
        'updated_at' => now(),
        'price' => '20.00'
    ],
    // Add more rows as needed
];

// Insert data
foreach ($data as $row) {
    $installer->getConnection()->insert($tableName, $row);
}

$installer->endSetup();