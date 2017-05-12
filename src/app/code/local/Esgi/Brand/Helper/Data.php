<?php

class Esgi_Brand_Helper_Data extends Mage_Core_Helper_Abstract
{
	const IMAGE_FOLDER = "brand";

	/**
	 * Renvoie l'URL de l'image
	 * @param $filename
	 * @return string
	 */
	public function getImageUrl($filename)
	{
		return Mage::getBaseUrl('media') . self::IMAGE_FOLDER . '/' . $filename;
	}

	/**
	 * return the url to access a brand
	 * @param Esgi_Brand_Model_Brand $brand
	 * @return string
	 */
	public function getBrandUrl(Esgi_Brand_Model_Brand $brand)
	{
		if (!$brand instanceof Esgi_Brand_Model_Brand) {
			return '#';
		}

		return $this->_getUrl(
			'esgi_brand/index/view',
			array(
				'url' => $brand->getSlug(),
			)
		);
	}
}
