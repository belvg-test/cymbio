<?php

/**
 * Resource model for Cymbio
 * Class Belvg_Cymbio_Model_Resource_Cymbio
 */
class Belvg_Cymbio_Model_Resource_Cymbio extends Mage_Core_Model_Resource_Db_Abstract
{
    /**
     * Define main table and primary index
     *
     */
    protected function _construct()
    {
        $this->_init('cymbio/cymbio', 'cymbio_id');
    }
}
