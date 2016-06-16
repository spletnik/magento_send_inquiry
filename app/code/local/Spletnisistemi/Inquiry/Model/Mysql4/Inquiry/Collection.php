<?php

class Spletnisistemi_Inquiry_Model_Mysql4_Inquiry_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract {

    protected $_previewFlag;

    public function _construct() {
        parent::_construct();
        $this->_init('inquiry/inquiry');

        $this->_map['fields']['inquiry_id'] = 'main_table.order_inquiries_id';
    }

    public function setFirstStoreFlag($flag = false) {
        $this->_previewFlag = $flag;
        return $this;
    }


    /**
     * Add Filter by store
     *
     * @param int|Mage_Core_Model_Store $store
     * @return Mage_Cms_Model_Mysql4_Page_Collection
     */
    public function addStoreFilter($store, $withAdmin = true) {
        if (!$this->getFlag('store_filter_added')) {
            if ($store instanceof Mage_Core_Model_Store) {
                $store = array($store->getId());
            }

            $this->getSelect()
                ->where('main_table.store_id in (?)', ($withAdmin ? array(0, $store) : $store))
                ->group('main_table.order_inquiries_id');

            $this->setFlag('store_filter_added', true);
        }

        return $this;
    }

}