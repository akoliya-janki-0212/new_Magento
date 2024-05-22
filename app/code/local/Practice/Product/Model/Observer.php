<?php  
class Practice_Product_Model_Observer{

    public function demo(){
      
        echo 'your cron is runing';
    }
    public function customPrice(Varien_Event_Observer $observer){
        $product = $observer->getEvent()->getProduct();
        $product->setProductName($product->getProductName().'abc'); 
    }
}