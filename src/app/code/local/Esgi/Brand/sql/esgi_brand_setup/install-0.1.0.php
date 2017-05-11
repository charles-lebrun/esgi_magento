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

// add a new product attribute to associate a brand to each product
$installer->addAttribute(Mage_Catalog_Model_Product::ENTITY, 'brand_id', array(
	'group'         => 'General',
	'label'         => 'Brand',
	'input'         => 'select',
	'source'        => 'esgi_brand/source_brand',
));

$installer->endSetup();
