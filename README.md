# Magento 2 Luis Ortega

## Quick Start 🚀

  * Up the conteiners: `docker-compose up --build`

Se crean 4 servicios:

Web: Pagina de magento con 2 productos cargados 
http://localhost/catalogsearch/result/?q=ProductTest

Provider: Node con data de prueba para emular el servicio del proveedor
http://localhost:3000/getAllSkuOffers/1000

Mysql: Base de datos en la que se encuentra toda la informacion guardada
-Se crea el campo offerid en las tablas quote_item y sales_order_item donde persistira el id de la mejor oferta
-Se adiciono la tabla report donde el cron Vendor\ChangePrice\Cron dejara la informacion consolidada de las cantidades vendidas por sku (El cron se dejo deshabilitado para no estar esperando que sea las 00:00h, se puede ejecutar manualmente)

Elasticsearch: elastic search que necesita magento para su funcionamiento