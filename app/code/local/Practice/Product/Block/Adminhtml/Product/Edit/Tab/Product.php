<?php
class Practice_Product_Block_Adminhtml_Product_Edit_Tab_Product extends Mage_Adminhtml_Block_Widget_Form implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
    }
    protected function _prepareForm()
    {
        /** @var $model Mage_Cms_Model_Page */
        $form = new Varien_Data_Form();
        $model = Mage::registry('practice_product');

        $fieldset = $form->addFieldset('product_fieldset', array('legend' => Mage::helper('practice_product')->__('Product Data')));
        if ($model->getId()) {
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
            )
        );
        if (!$model->getId()) {
            $fieldset->addField(
                'created_at',
                'date',
                array(
                    'name' => 'created_at',
                    'label' => Mage::helper('practice_product')->__('Created Date'),
                    'title' => Mage::helper('practice_product')->__('Created Date'),
                    'image' => $this->getSkinUrl('images/grid-cal.gif'),

                    'format' => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
                )
            );
        }
        $fieldset->addField(
            'updated_at',
            'date',
            array(
                'name' => 'updated_at',
                'label' => Mage::helper('practice_product')->__('Updated_Date'),
                'title' => Mage::helper('practice_product')->__('Updated_Date'),
                'format' => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
                'image' => $this->getSkinUrl('images/grid-cal.gif'),
            )
        );

        $form->setValues($model->getData());
        $this->setForm($form);
        return parent::_prepareForm();
    }
    public function getTabLabel()
    {
        return Mage::helper('practice_product')->__('Product');
    }

    public function getTabTitle()
    {
        return Mage::helper('practice_product')->__('Product');
    }
    public function canShowTab()
    {
        return true;
    }
    public function isHidden()
    {
        return false;
    }
}
