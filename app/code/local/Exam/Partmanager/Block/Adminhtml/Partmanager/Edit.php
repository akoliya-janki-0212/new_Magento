<?php
class Exam_Partmanager_Block_Adminhtml_Partmanager_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        $this->_objectId = 'mfr_id';
        $this->_blockGroup = 'exam_partmanager';
        $this->_controller = 'adminhtml_partmanager';
        parent::__construct();
        $this->_updateButton('save', 'label', Mage::helper('exam_partmanager')->__('Save Mfr'));
        $this->_updateButton('delete', 'label', Mage::helper('exam_partmanager')->__('Delete Mfr'));
     }
    /**
     * Get edit form container header text
     *
     * @return string
     */
    public function getHeaderText()
    {
        if (Mage::registry('mfr_registry')->getId()) {
            return Mage::helper('exam_partmanager')->__("Edit Product '%s'", 
            $this->escapeHtml(Mage::registry('mfr_registry')->getTitle()));
        } else {
            return Mage::helper('exam_partmanager')->__('New Product');
        }
    }
}
?>
