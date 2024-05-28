<?php
class Exam_Reportmanager_Model_Observer
{
    public function updateSoldCountSaveBefore(Varien_Event_Observer $observer)
    {
        $order = $observer->getEvent()->getOrder();
        foreach ($order->getAllItems() as $item) {
            $product = Mage::getModel('catalog/product')->load($item->getProductId());
            $soldCount = (int) $product->getSoldCount();
            $soldCount += (int) $item->getQtyOrdered();
            $product->setSoldCount($soldCount);
            $product->save();
        }
    }

    public function updateSoldCountDeleteBefore(Varien_Event_Observer $observer)
    {
        $order = $observer->getEvent()->getOrder();
        foreach ($order->getAllItems() as $item) {
            $product = Mage::getModel('catalog/product')->load($item->getProductId());
            $soldCount = (int) $product->getSoldCount();
            $soldCount -= (int) $item->getQtyOrdered();
            $product->setSoldCount($soldCount);
            $product->save();
        }
    }
}
