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
    //     $collection = Mage::getModel('practice_product/product')->getCollection();
    //     $this->setCollection($collection);
    //     return parent::_prepareCollection();
        $collection = Mage::getModel('practice_product/product')->getCollection()
        ->addFieldToSelect('product_id')
        ->addFieldToSelect('product_name');
    $collection->getSelect()->join(
        array('practice_categorys' => 'practice_categorys'),
        'main_table.product_id = practice_categorys.category_id',
        array('category_name' => 'category_name')
    );
    $this->setCollection($collection);
    parent::_prepareCollection();
    return $this;
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
                // 'column_css_class' => 'product_name',

            )
        );
        $this->addColumn(
            'category_name',
            array(
                'header' => Mage::helper('practice_product')->__('Category Name'),
                'width' => '50px',
                'type' => 'text',
                'index' => 'category_name',
                // 'column_css_class' => 'category_name',

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
        $this->addColumn('action',
        array(
            'header'    => Mage::helper('practice_product')->__('Action'),
            'width'     => '50px',
            'type'      => 'action',
            'getter'     => 'getId',
            'actions'   => array(
                array(
                    'caption' => Mage::helper('catalog')->__('Edit'),
                    'url'     => array(
                        'base'=>'*/*/edit',
                        'params'=>array('store'=>$this->getRequest()->getParam('store'))
                    ),
                    'field'   => 'id'
                )
            ),
            'filter'    => false,
            'sortable'  => false,
            'index'     => 'edit',
            // 'renderer' => 'practice_product/adminhtml_product_grid_renderer_editbutton',
    ));
            
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
    // public function getRowClass(Varien_Object $row)
    // {
    //     $primaryKey = $row->getId(); // Assuming 'jalebi_id' is the primary key
    //     return 'editable-' . $primaryKey;
    // }
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('product_id' => $row->getId()));
    }
}