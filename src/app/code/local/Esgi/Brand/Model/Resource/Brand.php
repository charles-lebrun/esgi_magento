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

}
