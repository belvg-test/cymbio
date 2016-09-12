<?php

/**
 * Custom add to cart button
 * Class Belvg_Cymbio_Block_Addtocart
 */
class Belvg_Cymbio_Block_Addtocart extends Mage_Catalog_Block_Product_View
{
    /**
     * Prepare custom add to cart url, add valiable is_custom=1
     * @return string
     */
    public function getCustomSubmitUrl()
    {
        return $this->getSubmitUrl($this->getProduct(), array('_secure' => $this->_isSecure(), 'is_custom' => 1));
    }
}