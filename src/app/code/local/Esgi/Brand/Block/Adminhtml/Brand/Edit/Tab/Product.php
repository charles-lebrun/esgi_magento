<?php

class Esgi_Brand_Block_Adminhtml_Brand_Edit_Tab_Product extends Mage_Adminhtml_Block_Widget_Form implements Mage_Adminhtml_Block_Widget_Tab_Interface
{

	protected function _prepareForm()
	{
		$form = new Varien_Data_Form();
		$this->setForm($form);
		$fieldset = $form->addFieldset('brand_form', array('legend' => Mage::helper('esgi_brand')->__('Product association')));

		$fieldset->addType('image', 'Esgi_Brand_Block_Adminhtml_Form_Renderer_Image');

		$fieldset->addField('name', 'text', array(
			'label'    => Mage::helper('esgi_brand')->__('Name'),
			'name'     => 'name',
			'class'    => 'required-entry',
			'required' => true
		));


		if (Mage::getSingleton('adminhtml/session')->getBrandData()) {
			$form->setValues(Mage::getSingleton('adminhtml/session')->getBrandData());
			Mage::getSingleton('adminhtml/session')->getBrandData(null);
		} elseif (Mage::registry('brand_data')) {
			$form->setValues(Mage::registry('brand_data')->getData());
		}

		return parent::_prepareForm();
	}

	public function getTabLabel()
	{
		return Mage::helper('esgi_brand')->__('Product Association');
	}

	public function getTabTitle()
	{
		return Mage::helper('esgi_brand')->__('Product Association');
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
