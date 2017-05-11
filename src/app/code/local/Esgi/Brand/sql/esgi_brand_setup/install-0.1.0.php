<?php

$installer = $this;
$installer->startSetup();

$brandTable = $installer->getConnection()
	->newTable($installer->getTable('esgi_brand/brand'))
	->addColumn('entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
		'identity' => true,
		'unsigned' => true,
		'nullable' => false,
		'primary'  => true,
	))
	->addColumn('name', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array())
	->addColumn('logo', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array())
	->addColumn('description', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array())
	->addColumn('slug', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array());
$installer->getConnection()->createTable($brandTable);

$table = $this->getConnection()
    ->newTable($this->getTable('esgi_brand/brand_product'))
    ->addColumn('rel_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned'  => true,
        'identity'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'Relation ID')
    ->addColumn('brand_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'default'   => '0',
    ), 'Brand ID')
    ->addColumn('product_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'default'   => '0',
    ), 'Product ID')
    ->addColumn('position', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable'  => false,
        'default'   => '0',
    ), 'Position')
    ->addIndex($this->getIdxName('esgi_brand/brand_product', array('product_id')), array('product_id'))
    ->addForeignKey($this->getFkName('esgi_brand/brand_product', 'brand_id', 'esgi_brand/brand', 'entity_id'), 'brand_id', $this->getTable('esgi_brand/brand'), 'entity_id', Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->addForeignKey($this->getFkName('esgi_brand/brand_product', 'product_id', 'catalog/product', 'entity_id'),    'product_id', $this->getTable('catalog/product'), 'entity_id', Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->setComment('Brand to Product Linkage Table');
$this->getConnection()->createTable($table);

$installer->endSetup();
