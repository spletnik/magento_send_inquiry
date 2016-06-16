<?php

class Spletnisistemi_Inquiry_Block_Adminhtml_Inquiry_Edit extends Mage_Adminhtml_Block_Widget_Form_Container {

    public function __construct() {
        parent::__construct();

        $this->_objectId = 'inquiry_id';
        $this->_blockGroup = 'inquiry';
        $this->_controller = 'adminhtml_inquiry';
        $this->_mode = 'edit';

        $this->_updateButton('save', 'label', Mage::helper('inquiry')->__('Save'));

        //generates delete url
        $currentId = Mage::registry('inquiry_inquiry')->getData("order_inquiries_id");
        $currentUrl = $this->getUrl('*/*/delete/inquiry_id/' . $currentId);

        $this->_addButton('delete', array(
            'label'   => Mage::helper('inquiry')->__('Delete'),
            'class'   => 'delete',
            'onclick' => 'setLocation(\'' . $currentUrl . '\')',
        ));

        $this->_removeButton('reset');

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('page_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'content');
                }
            }
        ";
    }

    /**
     * Retrieve text for header element depending on loaded page
     *
     * @return string
     */
    public function getHeaderText() {
        if (Mage::registry('inquiry_inquiry')->getId()) {
            return Mage::helper('inquiry')->__("Edit '%s'", $this->htmlEscape(Mage::registry('inquiry_inquiry')->getData("name") . " " . Mage::registry('inquiry_inquiry')->getData("last_name")));
        } else {
            return Mage::helper('inquiry')->getText(Mage::registry('inquiry_inquiry')->getData("category_id"), 'New');
        }
    }

}