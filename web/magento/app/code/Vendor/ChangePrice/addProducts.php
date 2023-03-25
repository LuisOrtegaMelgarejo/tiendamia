<?php
use Magento\Framework\App\Bootstrap;
include('app/bootstrap.php');
$bootstrap = Bootstrap::create(BP, $_SERVER);

$objectManager = $bootstrap->getObjectManager();

$state = $objectManager->get('Magento\Framework\App\State');
$state->setAreaCode('frontend');

$_product = $objectManager->create('Magento\Catalog\Model\Product');
$_product->setName('ProductTest');
$_product->setTypeId('simple');
$_product->setAttributeSetId(4);
$_product->setSku('1000');
$_product->setWebsiteIds(array(1));
$_product->setVisibility(4);
$_product->setPrice(0);
$_product->setStatus(1);
$_product->setStockData(array(
        'use_config_manage_stock' => 0,
        'manage_stock' => 0, //manage stock
        'min_sale_qty' => 1, 
        'is_in_stock' => 1
        )
    );

$_product->save();
?>