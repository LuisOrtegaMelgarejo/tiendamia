<?php
namespace Vendor\ChangePrice\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Exception\InputException;

class CustomPrice implements ObserverInterface {

    protected $messageManager;
    protected $zendClient;
    protected $_logger;
	
    public function __construct(\Magento\Framework\Message\ManagerInterface $messageManager, \Zend\Http\Client $zendClient, \Psr\Log\LoggerInterface $logger) {
        $this->messageManager = $messageManager;
        $this->zendClient = $zendClient;
        $this->_logger = $logger;
    }

    private function getBestOffer($carry, $item) {
        if(!isset($carry)) {
            $carry = $item;
        } else if (($carry->shipping_price + $carry->price) > ($item->shipping_price + $item->price)){
            $carry = $item;
        }
        return $carry;
    } 

    public function execute(\Magento\Framework\Event\Observer $observer) {
    
		$item = $observer->getEvent()->getData('quote_item');
        $product = $observer->getEvent()->getData('product');
		$item = ($item->getParentItem() ? $item->getParentItem() : $item);
		
        $url = 'http://provider:3000/getAllSkuOffers/'.$product->getSku();

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
            $bestOffer = array_reduce($availableOffers, array($this, 'getBestOffer'));
            $bestPrice = $bestOffer->shipping_price + $bestOffer->price;
            if ($bestPrice !== $product->getPrice()) {
                throw new InputException(__('El precio seleccionado ya no se encuentra disponible, por favor refresque la pantalla'));
            } else {
            $this->_logger->debug('Stocks '.$item->getQty().' - '.$bestOffer->stock);
                if ($item->getQty() > $bestOffer->stock) {
                    throw new InputException(__('No hay suficiente stock'));
                } 
            }
        }
        
        $item->setCustomPrice($bestPrice);
        $item->setOriginalCustomPrice($bestPrice);
        $item->setOfferid($bestOffer->id);
        $item->getProduct()->setIsSuperMode(true);

	}

}