<?php
class Practice_Product_Block_Adminhtml_Product_Edit_Tab_Category extends Mage_Adminhtml_Block_Widget_Form implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
    /**
     * Load Wysiwyg on demand and Prepare layout
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
      
    }

    protected function _prepareForm()
    {
        /** @var $model Mage_Cms_Model_Page */
        $form = new Varien_Data_Form();
        $model = Mage::registry('practice_category');
        $fieldset = $form->addFieldset('category_fieldset', array('legend' => Mage::helper('practice_product')->__('Category Data')));
        print_r($model->getId());
        if ($model->getId()) {
            $fieldset->addField(
                'category_id',
                'hidden',
                array(
                    'name' => 'category_id',
                )
            );
        }
        $fieldset->addField(
            'category_name',
            'text',
            array(
                'name' => 'category_name',
                'label' => Mage::helper('practice_product')->__('Category Name'),
                'title' => Mage::helper('practice_product')->__('Category Name'),
            )
        );
        $form->setValues($model->getData());
        $this->setForm($form);
        return parent::_prepareForm();
    }

    public function getTabLabel()
    {
        return Mage::helper('practice_product')->__('Category');
    }
  public function getTabTitle()
    {
        return Mage::helper('practice_product')->__('Category');
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
