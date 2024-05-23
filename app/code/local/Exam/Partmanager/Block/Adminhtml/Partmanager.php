<?php 
class Exam_Partmanager_Block_Adminhtml_Partmanager extends Mage_Adminhtml_Block_Widget_Grid_Container{
    public function __construct()
    {
      $this->_controller = 'adminhtml_partmanager';
        $this->_blockGroup = 'exam_partmanager';
        $this->_headerText = Mage::helper('exam_partmanager')->__('Manage Part');
        parent::__construct();
    }

}
