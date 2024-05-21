<?php
class Practice_Product_Block_Adminhtml_Product_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('productGrid');
        $this->setDefaultSort('products_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        // $this->setUseAjax(false);
        $this->setVarNameFilter('products_filter');
    }
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('practice_product/product')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }
    protected function _prepareColumns()
    {
        $this->addColumn(
            'product_name',
            array(
                'header' => Mage::helper('practice_product')->__('Name'),
                'width' => '50px',
                'type' => 'text',
                'index' => 'product_name',
            )
        );
        $this->addColumn(
            'created_at',
            array(
                'header' => Mage::helper('practice_product')->__('Created_at'),
                'width' => '50px',
                'type' => 'date',
                'index' => 'created_at',
            )
        );
        $this->addColumn(
            'updated_at',
            array(
                'header' => Mage::helper('practice_product')->__('Updated_At'),
                'width' => '50px',
                'type' => 'date',
                'index' => 'updated_at',
            )
        );
        $this->addColumn(
            'price',
            array(
                'header' => Mage::helper('practice_product')->__('Price'),
                'width' => '50px',
                'type' => 'integer',
                'index' => 'price',
            )
        );
        return parent::_prepareColumns();
    }
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('product_id'); // Field name for IDs
        $this->getMassactionBlock()->setFormFieldName('ids'); // Form field name containing selected IDs
        
        $this->getMassactionBlock()->addItem('delete', array(
             'label'   => Mage::helper('practice_product')->__('Delete'),
             'url'     => $this->getUrl('*/*/massDelete'), // Controller action URL
             'confirm' => Mage::helper('practice_product')->__('Are you sure?')
        ));

        return $this;
    }
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('product_id' => $row->getId()));
    }
}