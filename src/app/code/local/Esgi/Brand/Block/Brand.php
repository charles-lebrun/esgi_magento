<?php

class Esgi_Brand_Block_Brand extends Mage_Core_Block_Template
{
	public function getBrands()
	{
		$brands = Mage::getModel('esgi_brand/brand')
			->getCollection();

		return $brands;
	}
}
