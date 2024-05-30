<?php 
class Exam_Reportmanager_Block_Adminhtml_Reportmanager extends Mage_Adminhtml_Block_Widget_Grid_Container{
    public function __construct()
    {
      $this->_controller = 'adminhtml_reportmanager';
        $this->_blockGroup = 'exam_reportmanager';
        $this->_headerText = Mage::helper('exam_reportmanager')->__('Manage Report');
        parent::__construct();
        $this->_removeButton('add');
    }
}
