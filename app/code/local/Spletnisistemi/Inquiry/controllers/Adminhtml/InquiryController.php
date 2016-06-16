<?php

class Spletnisistemi_Inquiry_Adminhtml_InquiryController extends Mage_Adminhtml_Controller_action {

    public function indexAction() {
        $this->_initAction();
        $this->renderLayout();
    }

    protected function _initAction() {
        $this->loadLayout()
            ->_setActiveMenu('sales');

        return $this;
    }

    public function editAction() {
        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('inquiry_id');
        $model = Mage::getModel('inquiry/inquiry');

        // 2. Initial checking
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('inquiry')->__('This inquiry no longer exists'));
                $this->_redirect('*/*/');
                return;
            }
        }

        // 3. Set entered data if was error when we do save
        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }

        // 4. Register model to use later in blocks
        Mage::register('inquiry_inquiry', $model);

        // 5. Build edit form
        $this->_initAction();

        $this->renderLayout();
    }

    /**
     * Save action
     */
    public function saveAction() {
        // check if data sent
        if ($data = $this->getRequest()->getPost()) {
            //init model and set data
            $model = Mage::getModel('inquiry/inquiry');

            if ($id = $this->getRequest()->getParam('inquiry_id')) {
                $model->load($id);
            }

            $model->setData(array_merge($model->getData(), $data));

            // try to save it
            try {
                // save the data
                $model->save();

                // display success message
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('inquiry')->__('Inquiry was successfully saved'));
                // clear previously saved data from session
                Mage::getSingleton('adminhtml/session')->setFormData(false);

                // go to grid
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            } catch (Exception $e) {
                $this->_getSession()->addException($e, Mage::helper('inquiry')->__('Error while saving. Please try again later.' . $e));
            }

            $this->_getSession()->setFormData($data);
            $this->_redirect('*/*/edit', array('inquiry_id' => $this->getRequest()->getParam('inquiry_id')));
            return;
        }
        $this->_redirect('*/*/');
    }

    /**
     * Delete action
     */
    public function deleteAction() {
        // check if we know what should be deleted
        if ($id = $this->getRequest()->getParam('inquiry_id')) {
            $title = "";
            try {
                // init model and delete
                $model = Mage::getModel('inquiry/inquiry');
                $model->load($id);
                $title = $model->getId();
                $model->delete();
                // display success message
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('inquiry')->__('Inquiry was successfully deleted'));
                // go to grid
                Mage::dispatchEvent('adminhtml_cmspage_on_delete', array('title' => $title, 'status' => 'success'));

                $this->_redirect('*/*/');
                return;
            } catch (Exception $e) {
                Mage::dispatchEvent('adminhtml_inquiry_on_delete', array('title' => $title, 'status' => 'fail'));
                // display error message
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                // go back to edit form
                $this->_redirect('*/*/edit', array('inquiry_id' => $id));
                return;
            }
        }
        // display error message
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('inquiry')->__('Unable to find a inquiry to delete'));
        // go to grid
        $this->_redirect('*/*/');
    }
}

?>