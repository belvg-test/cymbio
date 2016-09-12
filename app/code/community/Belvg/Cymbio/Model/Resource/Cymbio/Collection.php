<?php

/**
 * Resource Model for Cymbio Collection
 * Class Belvg_Cymbio_Model_Resource_Cymbio_Collection
 */
class Belvg_Cymbio_Model_Resource_Cymbio_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    /**
     * Define resource model and model
     *
     */
    protected function _construct()
    {
        $this->_init('cymbio/cymbio');
    }
}
