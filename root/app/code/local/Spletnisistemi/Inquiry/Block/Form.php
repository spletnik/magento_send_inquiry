<?php


class Spletnisistemi_Inquiry_Block_Form extends Mage_Core_Block_Template {


    public function getFormActionUrl() {
        return Mage::getBaseUrl() . "inquiry/index/save";
    }


}