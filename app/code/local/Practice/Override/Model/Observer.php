<?php
class Practice_Override_Model_Observer
{
    public function bannerUpdated($observer)
    {
        $val = Mage::getStoreConfig('practice_test/settings/test1_enabled');
        Mage::getConfig()->saveConfig('advanced/modules_disable_output/Practice_Test', $val);

    }
    public function advancedUpdated($observer)
    {
        $val = Mage::getStoreConfig('advanced/modules_disable_output/Practice_Test');
        Mage::getConfig()->saveConfig('practice_test/settings/test1_enabled', $val);
    }

}