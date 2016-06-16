<?php

class Spletnisistemi_Inquiry_Model_Mysql4_Inquiry extends Mage_Core_Model_Mysql4_Abstract {

    /**
     * Store model
     *
     * @var null|Mage_Core_Model_Store
     */
    protected $_store = null;


    public function _construct() {
        // Note that the inquirys_id refers to the key field in your database table.
        $this->_init('inquiry/inquiry', 'order_inquiries_id');
    }

    /**
     * Retrieve store model
     *
     * @return Mage_Core_Model_Store
     */
    public function getStore() {
        return Mage::app()->getStore($this->_store);
    }

    /**
     * Set store model
     *
     * @param Mage_Core_Model_Store $store
     * @return Mage_Cms_Model_Mysql4_Page
     */
    public function setStore($store) {
        $this->_store = $store;
        return $this;
    }

    /**
     * Process page data before saving
     *
     * @param Mage_Core_Model_Abstract $object
     */
    protected function _beforeSave(Mage_Core_Model_Abstract $object) {

        if (!$object->getId() && $object->getCreationTime() == "") {
            $object->setCreated(Mage::getSingleton('core/date')->gmtDate());
        }

        if ($date = $object->getData('created')) {
            $new = Mage::app()->getLocale()->date($date)->toString();
            $object->setData('created', $new);
        }
        return $this;
    }
}