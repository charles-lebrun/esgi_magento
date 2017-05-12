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

	/**
	 * hook to create automaticly a slug for each brand
	 *
	 * @param Mage_Core_Model_Abstract $object
	 * @return $this
	 */
	protected function _beforeSave(Mage_Core_Model_Abstract $object)
	{
		if ($object->isObjectNew())
			$this->_prepareUrlKey($object);

		parent::_beforeSave($object);

		return $this;
	}


	/**
	 * create a slug and check unicity
	 *
	 * @param Mage_Core_Model_Abstract $object
	 * @return $this
	 */
	protected function _prepareUrlKey(&$object)
	{
		// check uniq slug
		$read = Mage::getSingleton('core/resource')->getConnection('core_read');
		$urlKey = Mage::getModel('catalog/product_url')->formatUrlKey($object->getName());

		$sql = 'SELECT * FROM esgi_brand_brand WHERE slug = ?';
		$row = $read->fetchRow($sql, array($urlKey));
		$idx = 1;
		while ($row != false) {
			$urlKey = Mage::getModel('catalog/product_url')->formatUrlKey($object->getName()) . '-' . $idx;
			$idx++;
			$row = $read->fetchRow($sql, array($urlKey));
		}

		$object->setSlug($urlKey);
		return $this;
	}

}
