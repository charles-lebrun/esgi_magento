<?php

class Esgi_Brand_IndexController extends Mage_Core_Controller_Front_Action
{
	/*
	 * list of brand
	*/
	public function indexAction()
	{
		$this->loadLayout();
		$this->renderLayout();
	}

	/**
	 * show a brand with associated products
	 */
	public function viewAction()
	{
		$brand = Mage::getModel('esgi_brand/brand');

		$urlKey = $this->getRequest()->getParam('url', '');
		if (strlen($urlKey) > 0) {
			$brand->load($urlKey, 'slug');
		} else {
			$id = (int)$this->getRequest()->getParam('id', 0);
			$brand->load($id);
		}

		if ($brand->getId() < 1) {
			$this->_redirect('*/*/index');
		}

		Mage::register('current_brand', $brand);

		$this->loadLayout()->renderLayout();
	}
}
