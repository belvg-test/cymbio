<?php

/**
 * Cymbio API wrapper
 * Class Belvg_Cymbio_Model_Api
 */
class Belvg_Cymbio_Model_Api
{
    /**
     * API entry point
     * @var string
     */
    protected $url = 'https://server-staging.cym.bio/v1/events/';

    /**
     * API request data
     * @var array
     */
    protected $data = array();

    /**
     * HTTP client
     * @var Varien_Http_Client
     */
    protected $httpClient;

    /**
     * Module helper
     * @var Belvg_Cymbio_Helper_Data
     */
    protected $helper;

    const EVENT_TYPE = 'ADD_TO_CART';

    public function __construct()
    {
        $this->helper = Mage::helper('cymbio');
        $this->data = array(
            'action' => self::EVENT_TYPE,
            'referer' => $this->helper->getStoreName(),
            'store_id' => $this->helper->getStoreId(),
            'product_id' => null,
            'query' => 'test query', // API fails without the "query" field
        );
    }

    /**
     * Set product Id
     * @param $productId
     * @return $this
     */
    public function setProductId($productId)
    {
        $this->data['product_id'] = $productId;
        return $this;
    }

    /**
     * Get product Id
     * @return mixed
     */
    public function getProductId()
    {
        return $this->data['product_id'];
    }

    /**
     * Send API request
     * view Belvg_Cymbio_Helper_Data::LOG_FILENAME_RESPONSE for the API response
     * view Belvg_Cymbio_Helper_Data::LOG_FILENAME_ERROR for the API errors and debug info
     * @return $this
     */
    public function send()
    {
        try {
            $this->valiate();

            $httpClient = new Varien_Http_Client();

            $response = $httpClient
                ->setUri($this->url)
                ->setConfig(array('useragent' => Mage::helper('cymbio')->getUserAgent()))
                ->setHeaders(array(
                    'Referer' => $this->helper->getProductUrl($this->getProductId()),
                    'Content-type' => 'application/json',
                ))
                ->setRawData($this->helper->jsonEncode($this->data), 'application/json')
                ->request(Zend_Http_Client::POST)
                ->getBody();
            Mage::log($response, null, Belvg_Cymbio_Helper_Data::LOG_FILENAME_RESPONSE);
        } catch (Exception $e) {
            Mage::log($e->getMessage(), null, Belvg_Cymbio_Helper_Data::LOG_FILENAME_ERROR);
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function valiate()
    {
        // do some data validation here
        return $this;
    }
}