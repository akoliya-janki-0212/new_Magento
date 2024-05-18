<?php
require_once 'Mage/Catalog/controllers/ProductController.php';
class Practice_Override_ProductController extends Mage_Catalog_ProductController
{
    public function viewAction()
    {
        // Your custom logic here
        echo "This is the overridden product view action!";
        // print_r(get_class(Mage::getModel('catalog/product')));
        // Call parent action
        parent::viewAction();
    }
}
