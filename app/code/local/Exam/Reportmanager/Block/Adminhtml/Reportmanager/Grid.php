<?php
class Exam_Reportmanager_Block_Adminhtml_Reportmanager_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('reportGrid');
    }
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('exam_reportmanager/report')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }
    protected function _prepareColumns()
    {
      
        $this->addColumn(
            'user_id',
            array(
                'header' => Mage::helper('exam_reportmanager')->__('User Name'),
                'width' => '50px',
                'type' => 'text',
                'index' => 'user_id',
            )
        );
        $this->addColumn(
            'report_type',
            array(
                'header' => Mage::helper('exam_reportmanager')->__('Report Type'),
                'width' => '50px',
                'type' => 'text',
                'index' => 'report_type',
            )
        );
        $this->addColumn(
            'filter_data',
            array(
                'header' => Mage::helper('exam_reportmanager')->__('Filter Data'),
                'width' => '50px',
                'type' => 'text',
                'index' => 'filter_data',
            )
        );
        $this->addColumn(
            'created_at',
            array(
                'header' => Mage::helper('exam_reportmanager')->__('Created At'),
                'width' => '50px',
                'type' => 'date',
                'index' => 'created_at',
            )
        );
        $this->addColumn(
            'updated_date',
            array(
                'header' => Mage::helper('exam_reportmanager')->__('Updated At'),
                'width' => '50px',
                'type' => 'date',
                'index' => 'updated_date',
            )
        );
        $this->addColumn(
            'is_active',
            array(
                'header' => Mage::helper('exam_reportmanager')->__('is_active'),
                'align' => 'left',
                'index' => 'is_active',
                'type' => 'options',
                'options' => array(
                    1 => Mage::helper('exam_reportmanager')->__('Yes'),
                    0 => Mage::helper('exam_reportmanager')->__('No')
                ),
            )
        );

        return parent::_prepareColumns();

    }
   
}
