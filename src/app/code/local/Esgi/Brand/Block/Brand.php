<?php

class Esgi_Brand_Block_Brand extends Mage_Core_Block_Template
{
	/*
	 * return a list of brand
	 *
	 * @return Array
	 */
	public function getBrands()
	{
		$brands = Mage::getModel('esgi_brand/brand')
			->getCollection()
			->setOrder('name', 'ASC');;

		return $brands;
	}

	/*
	 * return the current brand
	 */
	public function getCurrentBrand()
	{
		return Mage::registry('current_brand');
	}

	/*
	 * return a list of product associated to a brand
	 * enabled products + only product with visibility
	 *
	 * @return Array
	 */
	public function getProductCollection()
	{
		$brand = $this->getCurrentBrand();
		if (!$brand) {
			return array();
		}

		return Mage::getResourceModel('esgi_brand/brand_product_collection')
			->addAttributeToSelect('name', 'url')
			->addAttributeToFilter('status', array('eq' => Mage_Catalog_Model_Product_Status::STATUS_ENABLED))
			->addAttributeToFilter('visibility', array('neq' => Mage_Catalog_Model_Product_Visibility::VISIBILITY_NOT_VISIBLE))
			->addBrandFilter($brand)
			->setOrder('name', 'ASC');
	}
}
