<?php

/**
 * Cymbio observers
 * Class Belvg_Cymbio_Model_Observer
 */
class Belvg_Cymbio_Model_Observer
{
    /**
     * Process success add to cart event
     * @param Varien_Event_Observer $observer
     * @return $this
     * @throws Exception
     */
    function afterProductAdd(Varien_Event_Observer $observer)
    {
        $product = $observer->getProduct();
        /* @var $product Mage_Catalog_Model_Product */

        $request = $observer->getRequest();
        /* @var $$request Mage_Core_Controller_Request_Http */

        $isCustomRoute = (bool)$request->getParam('is_custom', false);
        // if our custom button was used
        if ($isCustomRoute) {
            $this->sendApiRequest($product);
            $this->saveProduct($product);
        }
        return $this;
    }

    /**
     * @param Mage_Catalog_Model_Product $product
     * @return $this
     */
    protected function sendApiRequest(Mage_Catalog_Model_Product $product)
    {
        $api = Mage::getModel('cymbio/api');
        /* @var $api Belvg_Cymbio_Model_Api */
        $api->setProductId($product->getId())->send();
        return $this;
    }

    /**
     * @param Mage_Catalog_Model_Product $product
     * @return $this
     */
    protected function saveProduct(Mage_Catalog_Model_Product $product)
    {
        try {
            $model = Mage::getModel('cymbio/cymbio');
            /* @var $model Belvg_Cymbio_Model_Cymbio */

            $data = array(
                'event' => 'ADD_TO_CART',
                'product_id' => $product->getId(),
                'product_price' => $product->getFInalPrice(),
                'product_description' => $product->getDescription()
            );

            $model->setData($data);
            $model->save();
        } catch (Exception $e) {
            Mage::log($e->getMessage(), null, Belvg_Cymbio_Helper_Data::LOG_FILENAME_ERROR);
        }

        return $this;
    }
}

