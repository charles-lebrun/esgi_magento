<?php

class Esgi_Brand_Block_Adminhtml_Brand_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	/**
	 *
	 */
	public function __construct()
	{
		parent::__construct();

		$this->setDefaultSort('entity_id');
		$this->setId('esgi_brand_brand_grid');
		$this->setDefaultDir('asc');
	}

	/**
	 * @return Mage_Adminhtml_Block_Widget_Grid
	 */
	protected function _prepareCollection()
	{
		$collection = Mage::getModel('esgi_brand/brand')->getCollection();
		$this->setCollection($collection);

		return parent::_prepareCollection();
	}

	/**
	 * @return $this
	 * @throws Exception
	 */
	protected function _prepareColumns()
	{

		$this->addColumn('entity_id', array(
			'header' => $this->__('ID'),
			'align'  => 'right',
			'width'  => '50px',
			'index'  => 'entity_id'
		));

		$this->addColumn('name', array(
			'header' => $this->__('Name'),
			'align'  => 'right',
			'width'  => '100px',
			'index'  => 'name'
		));

    	$this->addColumn('description', array(
			'header' => $this->__('Description'),
			'align'  => 'right',
			'width'  => '100px',
			'index'  => 'name'
		));

		$this->addColumn('slug', array(
			'header' => $this->__('Slug'),
			'align'  => 'right',
			'width'  => '100px',
			'index'  => 'slug'
		));

		return parent::_prepareColumns();
	}

	/**
	 * @return $this
	 */
	protected function _prepareMassaction()
	{
		$this->setMassactionIdField('entity_id');
		$this->getMassactionBlock()->setFormFieldName('brand');

		$this->getMassactionBlock()->addItem('delete', array(
			'label'   => Mage::helper('esgi_brand')->__('Delete'),
			'url'     => $this->getUrl('*/*/massDelete'),
			'confirm' => Mage::helper('esgi_brand')->__('Are you sure?')
		));

		$this->getMassactionBlock()->addItem('is_active', array(
			'label'      => Mage::helper('esgi_brand')->__('Change status'),
			'url'        => $this->getUrl('*/*/massStatus', array('_current' => true)),
			'additional' => array(
				'visibility' => array(
					'name'   => 'is_active',
					'type'   => 'select',
					'class'  => 'required-entry',
					'label'  => Mage::helper('esgi_brand')->__('Status'),
					'values' => Mage::getSingleton('adminhtml/system_config_source_enabledisable')->toOptionArray()
				)
			)
		));

		return $this;
	}

	/**
	 * Get row URL on click
	 *
	 * @param $row
	 *
	 * @return string
	 */
	public function getRowUrl($row)
	{
		return $this->getUrl('*/*/edit', array('id' => $row->getId()));
	}
}
