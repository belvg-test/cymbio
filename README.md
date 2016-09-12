# Cymbio test project

Create extension according to the  [description](https://docs.google.com/document/d/1I7tuS85QZJCPzR7zMg2T2_j-3SypP3-wXdMw85D_ApU/edit#)

## Plan

* create extension
* add custom "Add to cart" button (try not to override default theme templates, so lets inject block into "extra_buttons" or "product.info.extrahint")
* create model, resource and collection (make sure deprecated mysql4 resources work as well)
* create database installation script
* add observer to fire event after product was successfully added to the cart (`checkout_cart_add_product_complete` event).
* fill the database table
* create API wrapper (using `Varien_Http_Client`/`Zend_Http_Client`. [cymbio-php-sdk](http://api.cym.bio/v1) uses hardcoded url to the entry point, so does not match staging purposes);
* send API request, store the response into the log file.

## Working demo
http://dev2.belvg.net/cymbio/

Additional button is added to the product page. Button label is managed by the layout `setData` action. 

Only the custom button fires API call and cymbio table update. Default add to cart button adds the product, but observer is skipped.

API response is stored into the cymbio-response.log, module errors are logged in cymbio-error.log (see Belvg_Cymbio_Helper_Data).

Module creates `cymbio` table with the foreign key cymbio/product_id - catalog_product_entity/entity_id:

```
CREATE TABLE `cymbio` (
  `cymbio_id` int(10) UNSIGNED NOT NULL COMMENT 'Entity Id',
  `event` varchar(255) DEFAULT NULL COMMENT 'Type of the event',
  `product_id` int(10) UNSIGNED DEFAULT NULL COMMENT 'ID of the product',
  `product_price` decimal(12,4) NOT NULL DEFAULT '0.0000' COMMENT 'Price of the product',
  `product_description` varchar(255) DEFAULT NULL COMMENT 'Product description'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='cymbio';

ALTER TABLE `cymbio`
  ADD PRIMARY KEY (`cymbio_id`),
  ADD KEY `FK_CYMBIO_PRODUCT_ID_CATALOG_PRODUCT_ENTITY_ENTITY_ID` (`product_id`);

ALTER TABLE `cymbio`
  MODIFY `cymbio_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Entity Id';

ALTER TABLE `cymbio`
  ADD CONSTRAINT `FK_CYMBIO_PRODUCT_ID_CATALOG_PRODUCT_ENTITY_ENTITY_ID` FOREIGN KEY (`product_id`) REFERENCES `catalog_product_entity` (`entity_id`) ON DELETE SET NULL ON UPDATE NO ACTION;

```

## API integration problems

* Staging server requires "Referer" http header in the request (for now the product page URL is sent as the Referer header).
* "query" field is required (`{"message":"Request validation failed: Parameter (event) failed schema validation: 'Missing required property: query'","code":"InvalidInput"}`). This was not described in the specification.
* After the request is sent API returns `{"message":"Cannot read property 'product_id' of undefined","code":"InternalError"}`. There is no enough information for debugging. Tested solutions: int and string `product_id` types, using JSON encoded raw post data, using plain/text content type, using array post data, using splObject for sending post data. 

