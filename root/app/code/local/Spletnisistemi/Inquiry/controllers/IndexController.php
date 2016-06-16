<?php

/**
 * spletnisistemi
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the spletnisistemi EULA that is bundled with
 * this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.spletnisistemi.si/LICENSE-1.0.html
 *
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@spletnisistemi.si so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade the extension
 * to newer versions in the future. If you wish to customize the extension
 * for your needs please refer to http://www.spletnisistemi.si/ for more information
 * or send an email to sales@spletnisistemi.si
 *
 * @category   spletnisistemi
 * @package    spletnisistemi_MultiFees
 * @copyright  Copyright (c) 2009 spletnisistemi (http://www.spletnisistemi.si/)
 * @license    http://www.spletnisistemi.si/LICENSE-1.0.html
 */
class Spletnisistemi_Inquiry_IndexController extends Mage_Core_Controller_Front_Action {

    public function showFormAction() {

        $productId = $this->getRequest()->get('productId');

        /*$product = Mage::getModel('catalog/product')->load($productId);
        $productName = $product->getName(); */

        $layout = $this->loadLayout();

        $block = $this->getLayout()->createBlock(
            'inquiry/form', 'Inquiry Form', array('template' => 'inquiry/form.phtml')
        )->assign('productId', $productId);

        $block = $block->toHtml();

        echo json_encode($block);
        exit;
    }

    public function saveAction() {

        // check if data sent
        if ($data = $this->getRequest()->getPost()) {

            $validacija = $this->validateForm($data);

            // validate
            if (empty($validacija)) {

                //init model and set data
                $model = Mage::getModel('inquiry/inquiry');
                $model->setData($data);
                $model->setCreated(date('Y-m-d H:i:s'));

                // try to save it
                try {
                    // save the data
                    $model->save();

                    //sends email
                    $emailTemplate = Mage::getModel('core/email_template')
                        ->loadDefault('send_inquiry_mail_template');

                    $emailTemplate->setSenderName(Mage::app()->getStore()->getName());
                    $emailTemplate->setSenderEmail($data["email"]);

                    //change var name for emal template becouse magento override it
                    $data["customer_name"] = $data["name"];

                    $productId = $data["article"];

                    $_product = Mage::getModel('catalog/product')->load($productId);

                    $productName = $_product->getName();
                    //Update product name

                    $model->setArticleName($productName);
                    $model->save();

                    $data["article"] = $productName;

                    $data["url"] = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB) . $_product->getUrlPath();

                    //format data
                    $data_object = new Varien_Object();
                    $data_object->setData(
                        array(
                            'name'          => $data['name'],
                            'last_name'     => $data['last_name'],
                            'email'         => $data['email'],
                            'phone'         => $data['phone'],
                            'article'       => $data['article'],
                            'content'       => $data['content'],
                            'customer_name' => $data['name'],
                            'article'       => $productName,
                            'url'           => Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB) . $_product->getUrlPath(),
                        )
                    );

                    $vars = array('data' => $data_object);

                    $emailTemplate->send(Mage::getStoreConfig('trans_email/ident_general/email'), Mage::getStoreConfig('trans_email/ident_general/name'), $vars);

                    echo json_encode("<h2 id='inquiryMessage'>" . $this->__("Form was successfully saved.") . "</h2>");
                    exit;
                } catch (Mage_Core_Exception $e) {
                    $this->_getSession()->addError($e->getMessage());
                } catch (Exception $e) {
                    $this->_getSession()->addException($e, Mage::helper('inquiry')->__('Error while saving. Please try again later.' . $e));
                }
            } else {
                echo json_encode($validacija);
                exit;
            }
        }
    }

    public function validateForm($info) {

        $success = array();

        // preveri ce je ime
        if (empty($info['name'])) {
            $success[] = "name";
        }

        // preveri ce je lastname
        if (empty($info['last_name'])) {
            $success[] = "last_name";
        }

        if (empty($info['email'])) {
            $success[] = "email";
        } else {

            if ($this->validEmail($info['email']) != TRUE) {
                $success[] = "email";
            }
        }

        if (empty($info['content'])) {
            $success[] = "content";
        }

        return $success;
    }

    /**
     * Validate an email address.
     * Provide email address (raw input)
     * Returns true if the email address has the email
     * address format and the domain exists.
     */
    function validEmail($email) {
        $isValid = true;
        $atIndex = strrpos($email, "@");
        if (is_bool($atIndex) && !$atIndex) {
            $isValid = false;
        } else {
            $domain = substr($email, $atIndex + 1);
            $local = substr($email, 0, $atIndex);
            $localLen = strlen($local);
            $domainLen = strlen($domain);
            if ($localLen < 1 || $localLen > 64) {
                // local part length exceeded
                $isValid = false;
            } else if ($domainLen < 1 || $domainLen > 255) {
                // domain part length exceeded
                $isValid = false;
            } else if ($local[0] == '.' || $local[$localLen - 1] == '.') {
                // local part starts or ends with '.'
                $isValid = false;
            } else if (preg_match('/\\.\\./', $local)) {
                // local part has two consecutive dots
                $isValid = false;
            } else if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain)) {
                // character not valid in domain part
                $isValid = false;
            } else if (preg_match('/\\.\\./', $domain)) {
                // domain part has two consecutive dots
                $isValid = false;
            } else if (!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/', str_replace("\\\\", "", $local))) {
                // character not valid in local part unless
                // local part is quoted
                if (!preg_match('/^"(\\\\"|[^"])+"$/', str_replace("\\\\", "", $local))) {
                    $isValid = false;
                }
            }
            if ($isValid && !(checkdnsrr($domain, "MX") || checkdnsrr($domain, "A"))) {
                // domain not found in DNS
                $isValid = false;
            }
        }
        return $isValid;
    }

}