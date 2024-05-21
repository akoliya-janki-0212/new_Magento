<?php
class Practice_Test_Model_Observer
{
    protected $_data;
    public function demo(Varien_Event_Observer $observer)
    {
        echo '<pre>';
        $this->_data = $observer->getData();
        // print_r($data);die;
        // $observer->setData($data);
        // print_r($data);
        $this->_data['ggggg'] = 'abc';
        // print_r($observer->getData());
    }
    public function demos(Varien_Event_Observer $observer)
    {
        // echo '<pre>';
        // $data=$observer->getData();
        // print_r($data);die;
        // $observer->setData($data);
        // print_r($data);
        // $observer->setFirstName('abc');
        var_dump($this->_data);
    }
    public function logAdminLogin(Varien_Event_Observer $observer)
    {
        Mage::dispatchEvent('mne_bhukh_lagi_che');
        $user = $observer->getUser();
        $userId = $user->getId();
        $userName = $user->getUsername();
        $loginTime = now();
        Mage::log(" Admin user with ID: $userId and username: $userName logged in at $loginTime", null, 'admin_login.log');
    }
    public function copyCustomProductAttributes(Varien_Event_Observer $observer)
    {
        $item = $observer->getEvent()->getQuoteItem();
        $product = $observer->getEvent()->getProduct();
        $item->setData('price', $product->getPrice() * 2);
        if ($product->getBrand()) {
            $item->setData('brand', $product->getBrand());
        }
    }
    public function my_prac(){
        Mage::log("working ", null, 'janki.log');
        
    }

}