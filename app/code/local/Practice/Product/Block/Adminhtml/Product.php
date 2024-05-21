<?php
class Practice_Product_Block_Adminhtml_Product extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {

        $this->_controller = 'adminhtml_product';
        $this->_blockGroup = 'practice_product';
        $this->_headerText = Mage::helper('practice_product')->__('Manage Prodcucts');
        $this->_addButton('custom', array(
            'label' => 'demo',
            'onclick' => 'custom.testData2()',
            // 'class'     => 'add',
        )
        );
        parent::__construct();
    }
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        $this->getLayout()->getBlock('head')->addJs('practice_product/js/custom.js');
        return $this;
    }
}