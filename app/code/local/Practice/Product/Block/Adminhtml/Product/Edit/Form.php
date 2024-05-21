<?php
class Practice_Product_Block_Adminhtml_Product_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * Init form
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('product');
        $this->setTitle(Mage::helper('practice_product')->__('Product Information'));
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
        $model = Mage::registry('product_registry');
        $isEdit = ($model && $model->getId());
        $form = new Varien_Data_Form(
            array('id' => 'edit_form', 'action' => $this->getUrl('*/*/save'), 'method' => 'post', 'enctype' => 'multipart/form-data')
        );

        $form->setHtmlIdPrefix('block_');
        $fieldset = $form->addFieldset('base_fieldset', array('legend' => Mage::helper('practice_product')->__('General Information'), 'class' => 'fieldset-wide'));

        if ($isEdit && $model->getProductId()) {
            $fieldset->addField(
                'product_id',
                'hidden',
                array(
                    'name' => 'product_id',
                )
            );
        }
        $fieldset->addField(
            'product_name',
            'text',
            array(
                'name' => 'product_name',
                'label' => Mage::helper('practice_product')->__('Product Name'),
                'title' => Mage::helper('practice_product')->__('Product Name'),
                'required' => true,
            )
        );

        $fieldset->addField(
            'created at',
            'date',
            array(
                'name' => 'created_at',
                'label' => Mage::helper('practice_product')->__('Created Date'),
                'title' => Mage::helper('practice_product')->__('Created Date'),
                'image'     => $this->getSkinUrl('images/grid-cal.gif'),

                'format'    => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
                // Remove 'required' attribute only in edit mode
                'required' => !$isEdit,
            )
        );
  $fieldset->addField(
            'updated_at',
            'date',
            array(
                'name' => 'updated_at',
                'label' => Mage::helper('practice_product')->__('Updated_Date'),
                'title' => Mage::helper('practice_product')->__('Updated_Date'),
                'format'    => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
                'image'     => $this->getSkinUrl('images/grid-cal.gif'),

                // Remove 'required' attribute only in edit mode
                'required' => !$isEdit,
            )
        );

        $fieldset->addField(
            'status',
            'select',
            array(
                'label' => Mage::helper('practice_product')->__('Status'),
                'title' => Mage::helper('practice_product')->__('Status'),
                'name' => 'status',
                'required' => true,
                'options' => array(
                    '1' => Mage::helper('practice_product')->__('Enabled'),
                    '0' => Mage::helper('practice_product')->__('Disabled'),
                ),
            )
        );
        if (!($model->getId())) {
            $model->setData('status', '1');
        }

        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }

}
?>