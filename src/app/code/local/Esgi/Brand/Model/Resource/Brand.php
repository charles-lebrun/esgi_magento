<?php

class Esgi_Brand_Model_Resource_Brand extends Mage_Core_Model_Resource_Db_Abstract
{

    /**
     * Magento class constructor
     */
    protected function _construct()
    {
        $this->_init('esgi_brand/brand', 'entity_id');
    }

	protected function _beforeSave(Mage_Core_Model_Abstract $object)
	{

		/**
		 * create a slug
		 */
		$this->_prepareUrlKey($object);

		parent::_beforeSave($object);

		return $this;
	}


	protected function _prepareUrlKey(&$object)
	{
		$object->setSlug(Mage::getModel('catalog/product_url')->formatUrlKey( $object->getName() ));
		return $this;
	}

}
