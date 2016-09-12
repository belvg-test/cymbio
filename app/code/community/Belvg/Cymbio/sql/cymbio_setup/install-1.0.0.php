<?php

$installer = $this;
/* @var $installer Mage_Core_Model_Resource_Setup */

$installer->startSetup();


$table = $installer->getConnection()
    ->newTable($installer->getTable('cymbio/cymbio'))
    ->addColumn('cymbio_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
    ), 'Tag Id')
    ->addColumn('event', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
    ), 'Type of the event')
    ->addColumn('product_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned'  => true,
    ), 'ID of the product')
    ->addColumn('product_price', Varien_Db_Ddl_Table::TYPE_DECIMAL, '12,4', array(
        'nullable'  => false,
        'default'   => '0.0000',
    ), 'Price of the product')
    ->addColumn('product_description', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
    ), 'Product description')
    ->addForeignKey($installer->getFkName('cymbio/cymbio', 'product_id', 'catalog/product', 'entity_id'),
        'product_id', $installer->getTable('catalog/product'), 'entity_id',
        Varien_Db_Ddl_Table::ACTION_SET_NULL, Varien_Db_Ddl_Table::ACTION_NO_ACTION);
$installer->getConnection()->createTable($table);

$installer->endSetup();
