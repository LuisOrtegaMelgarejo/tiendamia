<?php

namespace Vendor\ChangePrice\Plugin;

class Product {

    protected $zendClient;
    protected $_logger;

    public function __construct(\Zend\Http\Client $zendClient, \Psr\Log\LoggerInterface $logger) {
        $this->zendClient = $zendClient;
        $this->_logger = $logger;
    }

    private function getLowCost($carry, $item) {
        if(!isset($carry)) {
            $carry = $item->shipping_price + $item->price;
        } else if ($carry > ($item->shipping_price + $item->price)){
            $carry = $item->shipping_price + $item->price;
        }
        return $carry;
    } 

    public function afterGetPrice(\Magento\Catalog\Model\Product $subject, $result) {

        $url = 'http://provider:3000/getAllSkuOffers/'.$subject->getSku();

        try {
            $this->zendClient->reset();
            $this->zendClient->setUri($url);
            $this->zendClient->setMethod(\Zend\Http\Request::METHOD_GET); 
            $this->zendClient->setHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ]);
            $this->zendClient->send();
            $response = $this->zendClient->getResponse();
        } catch (\Zend\Http\Exception\RuntimeException $runtimeException) {
            $this->_logger->debug($runtimeException->getMessage());
        }
        $data = json_decode($response->getContent());
        if(isset($data->offers)) {
            $availableOffers = array_filter($data->offers, function($offer){ 
                return $offer->stock > 0;
            });
            $minPrice = array_reduce($availableOffers, array($this, 'getLowCost'));
            $result = $minPrice;
        }

        return $result;
    }

}

