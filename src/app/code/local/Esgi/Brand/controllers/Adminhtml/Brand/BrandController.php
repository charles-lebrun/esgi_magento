<?php

class Esgi_Brand_Adminhtml_Brand_BrandController extends Mage_Adminhtml_Controller_Action
{

	/**
	 * @return Mage_Adminhtml_Controller_Action
	 */
	protected function _initAction()
	{
		return $this->loadLayout()->_setActiveMenu('esgi_brand');
	}

	/**
	 * @return Mage_Core_Controller_Varien_Action
	 */
	public function indexAction()
	{
		return $this->_initAction()->renderLayout();
	}

	/**
	 * @return $this
	 */
	public function newAction()
	{
		$this->_forward('edit');

		return $this;
	}

	/**
	 * @return $this|Mage_Core_Controller_Varien_Action
	 */
	public function editAction()
	{
		$id = $this->getRequest()->getParam('id');
		/** @var Esgi_Brand_Model_Brand $brand */
		$brand = Mage::getModel('esgi_brand/brand')->load($id);

		if ($brand->getId() || $id == 0) {

			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$brand->setData($data);
			}
			Mage::register('brand_data', $brand);

			return $this->_initAction()->renderLayout();
		}

		Mage::getSingleton('adminhtml/session')->addError(Mage::helper('esgi_brand')->__('Brand does not exist'));

		return $this->_redirect('*/*/');
	}

	/**
	 * @return $this|Mage_Core_Controller_Varien_Action
	 */
	public function saveAction()
	{
		if ($data = $this->getRequest()->getPost()) {

			$delete = (!isset($data['logo']['delete']) || $data['logo']['delete'] != '1') ? false : true;
			$data['image_url'] = $this->_saveImage('logo', $delete);

			/** @var Esgi_Brand_Model_Brand $brand */
			$brand = Mage::getModel('esgi_brand/brand');

			if ($id = $this->getRequest()->getParam('id')) {
				$brand->load($id);
			}

			try {
				$brand->addData($data);
				$brand->save();

				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('esgi_brand')->__('The brand has been saved.'));
				Mage::getSingleton('adminhtml/session')->setFormData(false);

				if ($this->getRequest()->getParam('back')) {
					$this->_redirect('*/*/edit', array(
						'id'       => $brand->getId(),
						'_current' => true
					));

					return;
				}

				$this->_redirect('*/*/');

				return;
			} catch (Mage_Core_Exception $e) {
				$this->_getSession()->addError($e->getMessage());
			} catch (Exception $e) {
				$this->_getSession()->addError($e->getMessage());
				$this->_getSession()->addException($e, Mage::helper('esgi_brand')->__('An error occurred while saving the brand.'));
			}

			$this->_getSession()->setFormData($data);
			$this->_redirect('*/*/edit', array(
				'id' => $this->getRequest()->getParam('id')
			));

			return;
		}
		$this->_redirect('*/*/');
	}

	/**
	 * @return $this|Mage_Core_Controller_Varien_Action
	 */
	public function deleteAction()
	{
		if ($id = $this->getRequest()->getParam('id')) {
			try {
        /** @var Esgi_Brand_Model_Brand $brand */
        $brand = Mage::getModel('esgi_brand/brand');
				$brand->load($id)->delete();

				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('esgi_brand')->__('Brand was successfully deleted'));
				$this->_redirect('*/*/');

				return;
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));

				return;
			}
		}

		return $this->_redirect('*/*/');
	}

	/**
	 * @return $this|Mage_Core_Controller_Varien_Action
	 */
	public function massDeleteAction()
	{
		$brandIds = $this->getRequest()->getParam('brand');
		if (!is_array($brandIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('esgi_brand')->__('Please select brarnd(s)'));
		} else {
			try {
				foreach ($brandIds as $brand) {
					Mage::getModel('esgi_brand/brand')->load($brand)->delete();
				}
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('esgi_brand')->__('Total of %d brand(s) were successfully deleted', count($brandIds)));
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
			}
		}

		return $this->_redirect('*/*/index');
	}

	/**
	 * @return $this|Mage_Core_Controller_Varien_Action
	 */
	public function massStatusAction()
	{
		$brandIds = $this->getRequest()->getParam('brand');
		if (!is_array($brandIds)) {
			Mage::getSingleton('adminhtml/session')->addError($this->__('Please select brand(s)'));
		} else {
			try {
				foreach ($brandIds as $brand) {
					Mage::getSingleton('esgi_brand/brand')->load($brand)->setIsActive($this->getRequest()->getParam('is_active'))->setIsMassupdate(true)->save();
				}
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('esgi_brand')->__('Total of %d brand(s) were successfully updated', count($brandIds)));
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
			}
		}

		return $this->_redirect('*/*/index');
	}

	/**
	 *
	 */
	protected function _saveImage($imageAttr, $delete)
	{
		if ($delete) {
			$image = '';
		} elseif (isset($_FILES[$imageAttr]['name']) && $_FILES[$imageAttr]['name'] != '') {
			try {
				$uploader = new Varien_File_Uploader($imageAttr);
				$uploader->setAllowedExtensions(array('jpg', 'jpeg', 'png'));
				$uploader->setAllowRenameFiles(false);
				$uploader->setFilesDispersion(false);
				$path = Mage::getBaseDir('media') . DS . 'brand' . DS;
				$uploader->save($path, $_FILES[$imageAttr]['name']);
				$image = $_FILES[$imageAttr]['name'];
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				return $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
			}
		} else {
			$model = Mage::getModel('esgi_brand/brand')->load($this->getRequest()->getParam('id'));
			$image = $model->getData($imageAttr);
		}
		return $image;
	}
}
