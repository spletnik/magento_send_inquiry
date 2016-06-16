<?php

class Spletnisistemi_Inquiry_Block_Adminhtml_Inquiry_Grid extends Mage_Adminhtml_Block_Widget_Grid {

    public function __construct() {
        parent::__construct();
        $this->setId('inquiryBlockGrid');
        $this->setDefaultSort('order_inquiries_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
    }

    public function getRowUrl($row) {
        return $this->getUrl('*/*/edit', array('inquiry_id' => $row->getId()));
    }

    protected function _prepareCollection() {
        $collection = Mage::getModel('inquiry/inquiry')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns() {
        $baseUrl = $this->getUrl();

        $this->addColumn('order_inquiries_id', array(
            'header' => Mage::helper('inquiry')->__("ID"),
            'align'  => 'left',
            'index'  => 'order_inquiries_id',
        ));

        $this->addColumn('article', array(
            'header' => Mage::helper('inquiry')->__("Product ID"),
            'align'  => 'left',
            'index'  => 'article',
        ));

        $this->addColumn('article_name', array(
            'header' => Mage::helper('inquiry')->__("Article Name"),
            'align'  => 'left',
            'index'  => 'article_name',
        ));

        $this->addColumn('name', array(
            'header' => Mage::helper('inquiry')->__("Name"),
            'align'  => 'left',
            'index'  => 'name',
        ));

        $this->addColumn('last_name', array(
            'header' => Mage::helper('inquiry')->__("Last name"),
            'align'  => 'left',
            'index'  => 'last_name',
        ));

        $this->addColumn('phone', array(
            'header' => Mage::helper('inquiry')->__("Phone"),
            'align'  => 'left',
            'index'  => 'phone',
        ));

        $this->addColumn('email', array(
            'header' => Mage::helper('inquiry')->__("E-mail"),
            'align'  => 'left',
            'index'  => 'email',
        ));

        $this->addColumn('created', array(
            'header' => Mage::helper('inquiry')->__('Date Created'),
            'index'  => 'created',
            'type'   => 'datetime',
        ));

        return parent::_prepareColumns();
    }

    protected function _afterLoadCollection() {
        $this->getCollection()->walk('afterLoad');
        parent::_afterLoadCollection();
    }

    protected function _filterStoreCondition($collection, $column) {
        if (!$value = $column->getFilter()->getValue()) {
            return;
        }

        $this->getCollection()->addStoreFilter($value);
    }

}