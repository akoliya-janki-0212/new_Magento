<?php
class Practice_Product_Block_Adminhtml_Product_Grid_Renderer_Editbutton extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    protected static $rowCounter = 0;
    public function render(Varien_Object $row)
    {
        // Render competitor information
        $productId = $row->getData('product_id');
        // $status = array(
        //     '1' => 'Enabled',
        //     '2' => 'Disabled'
        // );
        // $status = json_encode($status);
        $editUrl = $this->getUrl('*/*/save', array('product_id' => $productId));
        $output = "<a href='#' class='edit-jalebi' data-url='{$editUrl}' data-jalebi-id='{$productId}'>Edit</a>";
        return $output;
    }
}