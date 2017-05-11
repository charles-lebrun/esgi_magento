<?php

class Esgi_Brand_Model_Brand extends Mage_Core_Model_Abstract
{

	/**
	 * Name of object id field
	 *
	 * @var string
	 */
	protected $_idFieldName = 'entity_id';

	/**
	 * Magento class constructor
	 */
	protected function _construct()
	{
		$this->_init('esgi_brand/brand');
	}


	public function getAllOptions()
	{
		$brandCollection = Mage::getModel('esgi_brand/brand')->getCollection()
			->setOrder('name', 'ASC');

		$options = array(
			array(
				'label' => '',
				'value' => '',
			),
		);

		foreach ($brandCollection as $_brand) {
			$options[] = array(
				'label' => $_brand->getName(),
				'value' => $_brand->getId(),
			);
		}

		return $options;
	}

}
