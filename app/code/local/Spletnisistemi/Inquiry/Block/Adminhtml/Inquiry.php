<?php

class Spletnisistemi_Inquiry_Block_Adminhtml_Inquiry extends Mage_Adminhtml_Block_Widget_Grid_Container {

    public function __construct() {
        parent::__construct();
        $this->removeButton("add");
        $this->_controller = 'adminhtml_inquiry';
        $this->_blockGroup = 'inquiry';

        $this->_headerText = Mage::helper('inquiry')->__('Inquiries');
    }

    protected function _prepareLayout() {
        $this->setChild('grid', $this->getLayout()->createBlock($this->_blockGroup . '/' . $this->_controller . '_grid', $this->_controller . '.grid')->setSaveParametersInSession(true));
        return parent::_prepareLayout();
    }

}