<?php

class Spletnisistemi_Inquiry_Block_Adminhtml_Inquiry_Edit_Form extends Mage_Adminhtml_Block_Widget_Form {

    /**
     * Load Wysiwyg on demand and Prepare layout
     */
    protected function _prepareLayout() {
        parent::_prepareLayout();
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
    }

    protected function _prepareForm() {
        if (Mage::getSingleton('adminhtml/session')->getInquiryData()) {
            $data = Mage::getSingleton('adminhtml/session')->getInquiryData();
            Mage::getSingleton('adminhtml/session')->getInquiryData(null);
        } elseif (Mage::registry('inquiry_inquiry')) {
            $data = Mage::registry('inquiry_inquiry')->getData();
        } else {
            $data = array();
        }
        $product = Mage::getModel('catalog/product')->load($data["article"]);
        $form = new Varien_Data_Form(array(
            'id'      => 'edit_form',
            'action'  => $this->getUrl('*/*/save', array('inquiry_id' => $this->getRequest()->getParam('inquiry_id'))),
            'method'  => 'post',
            'enctype' => 'multipart/form-data',
        ));

        $form->setUseContainer(true);

        $this->setForm($form);

        $fieldset = $form->addFieldset('inquiry_form', array(
            'legend' => Mage::helper('inquiry')->__('Inquiry content'),
        ));

        $fieldset->addType('extended_label', 'Spletnisistemi_Inquiry_Lib_Varien_Data_Form_Element_ExtendedLabel');
        $fieldset->addField('mycustom_element', 'extended_label', array(
            'label'    => '<a href="' . $product->getProductUrl() . '">' . $product->getName() . '</a>',
            'name'     => 'mycustom_element',
            'required' => false,
            //'value'         => 'Uplaod',//$this->getLastEventLabel($lastEvent),
            'bold'     => true,
            //'label_style'   => 'font-weight: bold;color:red;',
            //'note'      => 'Frontend url: '.'<a href="'.$product->getProductUrl().'">Frontend</a>',
            //'after_element_html' => 'Frontend url: '.'<a href="'.$product->getProductUrl().'">link</a>',
        ));

        /*$fieldset->addField('article', 'label', array(
                        'label' => Mage::helper('inquiry')->__('Article'),
                        'name' => 'article'
        */

        $fieldset->addField('name', 'text', array(
            'class'    => 'required-entry',
            'required' => true,
            'label'    => Mage::helper('inquiry')->__('Name'),
            'name'     => 'name',
        ));

        $fieldset->addField('last_name', 'text', array(
            'label'    => Mage::helper('inquiry')->__('Last name'),
            'class'    => 'required-entry',
            'required' => true,
            'name'     => 'last_name',
        ));

        $fieldset->addField('email', 'text', array(
            'label'    => Mage::helper('inquiry')->__('E-mail'),
            'class'    => 'required-entry',
            'required' => true,
            'name'     => 'email',
        ));

        $fieldset->addField('phone', 'text', array(
            'label'    => Mage::helper('inquiry')->__('Phone'),
            'class'    => '',
            'required' => false,
            'name'     => 'phone',
        ));

        $wysiwygConfig = Mage::getSingleton('cms/wysiwyg_config')->getConfig();

        //make Wysiwyg Editor integrate in the form
        $wysiwygConfig["files_browser_window_url"] = Mage::getSingleton('adminhtml/url')->getUrl('adminhtml/cms_wysiwyg_images/index');
        $wysiwygConfig["directives_url"] = Mage::getSingleton('adminhtml/url')->getUrl('adminhtml/cms_wysiwyg/directive');
        $wysiwygConfig["directives_url_quoted"] = Mage::getSingleton('adminhtml/url')->getUrl('adminhtml/cms_wysiwyg/directive');
        $wysiwygConfig["widget_window_url"] = Mage::getSingleton('adminhtml/url')->getUrl('adminhtml/widget/index');
        $plugins = $wysiwygConfig->getData("plugins");
        $plugins[0]["options"]["url"] = Mage::getSingleton('adminhtml/url')->getUrl('adminhtml/system_variable/wysiwygPlugin');
        $plugins[0]["options"]["onclick"]["subject"] = "MagentovariablePlugin.loadChooser('" . Mage::getSingleton('adminhtml/url')->getUrl('adminhtml/system_variable/wysiwygPlugin') . "', '{{html_id}}');";
        $plugins = $wysiwygConfig->setData("plugins", $plugins);
        $contentField = $fieldset->addField('content', 'editor', array(
            'name'     => 'content',
            'label'    => Mage::helper('inquiry')->__('Content'),
            'style'    => 'height:20em; width:50em;',
            'required' => true,
            'disabled' => $isElementDisabled,
            'config'   => $wysiwygConfig,
        ));

        $form->setValues($data);
        return parent::_prepareForm();
    }

}
