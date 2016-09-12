<?php

/**
 * Cymbio Module helper
 * Class Belvg_Cymbio_Helper_Data
 */
class Belvg_Cymbio_Helper_Data extends Mage_Core_Helper_Data
{
    const LOG_FILENAME_ERROR = 'cymbio-error.log';
    const LOG_FILENAME_RESPONSE = 'cymbio-response.log';

    /**
     * Get store view object
     * @return Mage_Core_Model_Store
     */
    public function getStore()
    {
        return Mage::app()->getStore();
    }

    /**
     * Get store view name
     * @return string
     */
    public function getStoreName()
    {
        return $this->getStore()->getName();
    }

    /**
     * Get module version
     * @return string
     */
    public function getVersion()
    {
        return (string)Mage::getConfig()->getModuleConfig('Belvg_Cymbio')->version;
    }

    /**
     * Format User Agent for the API request
     * @return string
     */
    public function getUserAgent()
    {
        return sprintf('Cymbio Magento API %s/%s', Mage::getVersion(), $this->getVersion());
    }

    /**
     * Get product url for the Referer header
     * @param int $productId
     * @return string
     * @throws Mage_Core_Exception
     */
    public function getProductUrl($productId)
    {
        $product = Mage::getModel('catalog/product')->load($productId);
        /* @var $product Mage_Catalog_Model_Product */
        if (!$product->getId()) {
            Mage::throwException(sprintf('Product with id %s was not found', $productId));
        }

        return $product->getProductUrl();
    }
}