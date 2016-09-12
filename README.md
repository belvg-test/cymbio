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

## API integration problems

* Staging server requires "Referer" http header in the request (for now the product page URL is sent as the Referer header).
* "query" field is required (`{"message":"Request validation failed: Parameter (event) failed schema validation: 'Missing required property: query'","code":"InvalidInput"}`). This was not described in the specification.
* After the request is sent API returns `{"message":"Cannot read property 'product_id' of undefined","code":"InternalError"}`. There is no enough information for debugging. Tested solutions: int and string `product_id` types, using JSON encoded raw post data, using plain/text content type, using array post data, using splObject for sending post data. 

