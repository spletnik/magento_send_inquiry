<?php

class Spletnisistemi_Inquiry_Model_Source extends Mage_Eav_Model_Entity_Attribute_Source_Abstract {
    public function getAllOptions() {
        if (!$this->_options) {
            $this->_options = array(
                array(
                    'value' => 0,
                    'label' => 'No',
                ),
                array(
                    'value' => 1,
                    'label' => 'Yes, with price',
                ),
                array(
                    'value' => 2,
                    'label' => 'Yes, without price',
                ),
            );
        }
        return $this->_options;
    }
}