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
$installer->getConnection()->createTable($brandTable);

$installer->endSetup();
