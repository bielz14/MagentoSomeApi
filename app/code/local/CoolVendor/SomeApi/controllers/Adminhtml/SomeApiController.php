<?php
class CoolVendor_SomeApi_Adminhtml_SomeApiController extends Mage_Adminhtml_Controller_Action {

    public function indexAction()
    {
        $this->loadLayout();

        $this->renderLayout();

    }

    public function ticketFormAction()
    {
        $this->loadLayout()->_addContent(
                   $this->getLayout()
                    ->createBlock('coolvendor_someapi/adminhtml_form')
                    ->setTemplate('coolvendor_someapi/form.phtml'))
            ->renderLayout();
    }

    public function sendTicketAction()
    {
       //TOD:
    }
}