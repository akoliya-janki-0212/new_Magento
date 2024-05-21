<?php
class Practice_Product_Block_Adminhtml_Product_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        $this->_objectId = 'product_id';
        $this->_blockGroup = 'practice_product';
        $this->_controller = 'adminhtml_product';
        parent::__construct();
        $this->_updateButton('save', 'label', Mage::helper('practice_product')->__('Save Product'));
        $this->_updateButton('delete', 'label', Mage::helper('practice_product')->__('Delete Product'));
        // $this->_addButton('delete', array('label'=>Mage::helper('practice_product')->__('Delete Product')));
        // $this->_addButton('saveandcontinue', array(
        //     'label' => Mage::helper('practice_product')->__('Save and Continue Edit'),
        //     'onclick' => 'saveAndContinueEdit()',
        //     'class' => 'save',
        // ), -100);
     }
    /**
     * Get edit form container header text
     *
     * @return string
     */
    public function getHeaderText()
    {
        if (Mage::registry('product_registry')->getId()) {
            return Mage::helper('practice_product')->__("Edit Product '%s'", 
            $this->escapeHtml(Mage::registry('product_registry')->getTitle()));
        } else {
            return Mage::helper('practice_product')->__('New Product');
        }
    }
}
?>