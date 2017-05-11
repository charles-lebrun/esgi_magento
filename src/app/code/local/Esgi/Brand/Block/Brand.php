<?php

class Esgi_Brand_Block_Brand extends Mage_Core_Block_Template
{
	public function getBrands()
	{
		$brands = Mage::getModel('esgi_brand/brand')
			->getCollection()
			->setOrder('name', 'ASC');;

		return $brands;
	}

	public function getCurrentBrand()
	{
		return Mage::registry('current_brand');
	}

	public function getProductCollection()
	{
		$brand = $this->getCurrentBrand();
		if (!$brand) {
			return array();
		}

		return Mage::getModel('catalog/product')->getCollection()
			->addAttributeToSelect('name')
			->addAttributeToFilter('brand_id', $brand->getId())
			->setOrder('name', 'ASC');
	}
}
