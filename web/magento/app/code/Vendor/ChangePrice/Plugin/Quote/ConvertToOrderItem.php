<?php

namespace Vendor\ChangePrice\Plugin\Quote;

class ConvertToOrderItem {

	public function aroundConvert(
        \Magento\Quote\Model\Quote\Item\ToOrderItem $subject,
        \Closure $proceed,
        \Magento\Quote\Model\Quote\Item\AbstractItem $item,
        $additional = []
    ) {
        $orderItem = $proceed($item, $additional);
		$orderItem->setOfferid($item->getOfferid());
        return $orderItem;
    }
}