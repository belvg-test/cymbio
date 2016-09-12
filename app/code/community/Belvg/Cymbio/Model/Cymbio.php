<?php

/**
 * Cymbio model
 * Class Belvg_Cymbio_Model_Cymbio
 */
class Belvg_Cymbio_Model_Cymbio extends Mage_Core_Model_Abstract
{
    /**
     * Entity code.
     * Can be used as part of method name for entity processing
     */
    const ENTITY = 'cymbio';

    /**
     * Event prefix for observer
     *
     * @var string
     */
    protected $_eventPrefix = 'cymbio';

    protected function _construct()
    {
        $this->_init('cymbio/cymbio');
    }
}
