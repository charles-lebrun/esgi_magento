<?php
class Esgi_Brand_Model_Brand_Product extends Mage_Core_Model_Abstract {

	/**
	 *
	 */
    protected function _construct(){
        $this->_init('esgi_brand/brand_product');
    }

	/**
	 * @param $brand
	 * @return $this
	 */
    public function saveBrandRelation($brand){
        $data = $brand->getProductsData();
        if (!is_null($data)) {
            $this->_getResource()->saveBrandRelation($brand, $data);
        }
        return $this;
    }

	/**
	 * @param $brand
	 * @return mixed
	 */
    public function getProductCollection($brand){
        $collection = Mage::getResourceModel('esgi_brand/brand_product_collection')
            ->addBrandFilter($brand);
        return $collection;
    }
}
