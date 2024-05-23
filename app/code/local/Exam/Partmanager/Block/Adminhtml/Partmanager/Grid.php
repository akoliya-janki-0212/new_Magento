<?php
class Exam_Partmanager_Block_Adminhtml_Partmanager_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('partGrid');
        // $this->setTemplate('Exam/grid/container.phtml');
        // $this->setDefaultSort('products_id');
        // $this->setDefaultDir('DESC');
        // $this->setSaveParametersInSession(true);
        // $this->setUseAjax(true);
        // $this->setVarNameFilter('products_filter');
    }
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('exam_partmanager/mfr')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }
    protected function _prepareColumns()
    {
        // $this->addColumn(
        //     'mfr_id',
        //     array(
        //         'header' => Mage::helper('exam_partmanager')->__('Mfr Id'),
        //         'width' => '50px',
        //         'type' => 'number',
        //         'index' => 'mfr_id',
        //     )
        // );
        $this->addColumn(
            'mfr',
            array(
                'header' => Mage::helper('exam_partmanager')->__('Mfr'),
                'width' => '50px',
                'type' => 'text',
                'index' => 'mfr',
            )
        );
        $this->addColumn(
            'address',
            array(
                'header' => Mage::helper('exam_partmanager')->__('Address'),
                'width' => '50px',
                'type' => 'text',
                'index' => 'address',
            )
        );
        $this->addColumn(
            'city',
            array(
                'header' => Mage::helper('exam_partmanager')->__('City'),
                'width' => '50px',
                'type' => 'text',
                'index' => 'city',
            )
        );
        $this->addColumn(
            'state',
            array(
                'header' => Mage::helper('exam_partmanager')->__('State'),
                'width' => '50px',
                'type' => 'text',
                'index' => 'state',
            )
        );
        $this->addColumn(
            'country',
            array(
                'header' => Mage::helper('exam_partmanager')->__('Country'),
                'width' => '50px',
                'type' => 'text',
                'index' => 'country',
            )
        );
        $this->addColumn(
            'created_at',
            array(
                'header' => Mage::helper('exam_partmanager')->__('Created At'),
                'width' => '50px',
                'type' => 'date',
                'index' => 'created_at',
            )
        );
        $this->addColumn(
            'updated_date',
            array(
                'header' => Mage::helper('exam_partmanager')->__('Updated At'),
                'width' => '50px',
                'type' => 'date',
                'index' => 'updated_date',
            )
        );
        $this->addColumn(
            'is_active',
            array(
                'header' => Mage::helper('banner')->__('is_active'),
                'align' => 'left',
                'index' => 'is_active',
               
            )
        );
        return parent::_prepareColumns();

    }
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('mfr_id');
        $this->getMassactionBlock()->setFormFieldName('mfr_id'); // Change to 'banner_id'

        $activeOptions = Mage::getSingleton('exam_partmanager/isactive')->getOptionArray();

        array_unshift($activeOptions, array('label' => '', 'value' => ''));
        $this->getMassactionBlock()->addItem(
            'is_active',
            array(
                'label' => Mage::helper('exam_partmanager')->__('Change Is active'),
                'url' => $this->getUrl('*/*/massIsactive', array('_current' => true)),
                'additional' => array(
                    'visibility' => array(
                        'name' => 'is_active',
                        'type' => 'select',
                        'class' => 'required-entry',
                        'label' => Mage::helper('exam_partmanager')->__('Is Active'),
                        'values' => $activeOptions
                    )
                )
            )
        );

        // Mage::dispatchEvent('banner_adminhtml_banner_grid_prepare_massaction', array('block' => $this));
        return $this;
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('mfr_id' => $row->getId()));
    }
}
