<?php
class Exam_Partmanager_Block_Adminhtml_Partmanager_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * Init form
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('mfr');
        $this->setTitle(Mage::helper('exam_partmanager')->__('Product Information'));
        $this->setData('product_form', $this->getUrl('*/*/save'));
    }

    /**
     * Load Wysiwyg on demand and Prepare layout
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
    }

    protected function _prepareForm()
    {
        $model = Mage::registry('mfr_registry');
        $isEdit = ($model && $model->getId());
        $form = new Varien_Data_Form(
            array('id' => 'edit_form', 'action' => $this->getUrl('*/*/save'), 'method' => 'post', 'enctype' => 'multipart/form-data')
        );

        $form->setHtmlIdPrefix('block_');
        $fieldset = $form->addFieldset('base_fieldset', array('legend' => Mage::helper('exam_partmanager')->__('General Information'), 'class' => 'fieldset-wide'));

        if ($isEdit && $model->getMfrId()) {
            $fieldset->addField(
                'mfr_id',
                'hidden',
                array(
                    'name' => 'mfr_id',
                )
            );
        }
        
        $fieldset->addField(
            'mfr',
            'text',
            array(
                'name' => 'mfr',
                'label' => Mage::helper('exam_partmanager')->__('Mfr'),
                'title' => Mage::helper('exam_partmanager')->__('Mfr'),
                'required' => true,
            )
        );
        $fieldset->addField(
            'address',
            'text',
            array(
                'name' => 'address',
                'label' => Mage::helper('exam_partmanager')->__('Address'),
                'title' => Mage::helper('exam_partmanager')->__('Address'),
                'required' => true,
            )
        );
        $fieldset->addField(
            'city',
            'text',
            array(
                'name' => 'city',
                'label' => Mage::helper('exam_partmanager')->__('City'),
                'title' => Mage::helper('exam_partmanager')->__('City'),
                'required' => true,
            )
        );
        $fieldset->addField(
            'state',
            'text',
            array(
                'name' => 'state',
                'label' => Mage::helper('exam_partmanager')->__('State'),
                'title' => Mage::helper('exam_partmanager')->__('State'),
                'required' => true,
            )
        );
        $fieldset->addField(
            'country',
            'text',
            array(
                'name' => 'country',
                'label' => Mage::helper('exam_partmanager')->__('Country'),
                'title' => Mage::helper('exam_partmanager')->__('Country'),
                'required' => true,
            )
        );
      
        $fieldset->addField(
            'created at',
            'date',
            array(
                'name' => 'created at',
                'label' => Mage::helper('exam_partmanager')->__('Created Date'),
                'title' => Mage::helper('exam_partmanager')->__('Created Date'),
                'image'     => $this->getSkinUrl('images/grid-cal.gif'),
                'format'    => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
                'required' => !$isEdit,
            )
        );
  $fieldset->addField(
            'updated_date',
            'date',
            array(
                'name' => 'updated_date',
                'label' => Mage::helper('exam_partmanager')->__('Updated_Date'),
                'title' => Mage::helper('exam_partmanager')->__('Updated_Date'),
                'format'    => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
                'image'     => $this->getSkinUrl('images/grid-cal.gif'),
                'required' => !$isEdit,
            )
        );

        $fieldset->addField(
            'is_active',
            'select',
            array(
                'label' => Mage::helper('exam_partmanager')->__('is_active'),
                'title' => Mage::helper('exam_partmanager')->__('is_active'),
                'name' => 'is_active',
                'required' => true,
                'options' => array(
                    '1' => Mage::helper('exam_partmanager')->__('Yes'),
                    '0' => Mage::helper('exam_partmanager')->__('No'),
                ),
            )
        );
        if (!($model->getId())) {
            $model->setData('is_active', '1');
        }

        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }

}
?>
