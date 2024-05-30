<?php
class Ccc_Outlook_Block_Adminhtml_Configuration_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct($attributes = array())
    {
        parent::__construct($attributes);

    }
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('ccc_outlook/configuration')->getCollection();
        $this->setCollection($collection);
        parent::_prepareCollection();
        return $this;
    }

    protected function _prepareColumns()
    {
        $this->addColumn(
            'username',
            array(
                'header' => Mage::helper('ccc_outlook')->__('User Name'),
                'id'=> 'username',
                'align' => 'right',
                'width' => '50px',
                'index' => 'username',
            )
        );
        $this->addColumn(
            'email',
            array(
                'header' => Mage::helper('ccc_outlook')->__('Email'),
                'align' => 'right',
                'width' => '50px',
                'index' => 'email',
            )
        );
        $this->addColumn(
            'api_key',
            array(
                'header' => Mage::helper('ccc_outlook')->__('Api Key'),
                'align' => 'right',
                'width' => '50px',
                'index' => 'api_key',
            )
        );
        
        $this->addColumn(
            'token',
            array(
                'header' => Mage::helper('ccc_outlook')->__('Token'),
                'align' => 'right',
                'width' => '50px',
                'index' => 'token',
            )
        );
        $this->addColumn(
            'api_key',
            array(
                'header' => Mage::helper('ccc_outlook')->__('Api Key'),
                'align' => 'right',
                'width' => '50px',
                'index' => 'api_key',
            )
        );
        $this->addColumn(
            'is_active',
            array(
                'header' => Mage::helper('ccc_outlook')->__('is_active'),
                'align' => 'left',
                'index' => 'is_active',
                'type' => 'options',
                'options' => array(
                    1 => Mage::helper('ccc_outlook')->__('Yes'),
                    0 => Mage::helper('ccc_outlook')->__('No')
                ),
            )
        );
        return parent::_prepareColumns();
    }
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('configuration_id' => $row->getId()));
    }
}
