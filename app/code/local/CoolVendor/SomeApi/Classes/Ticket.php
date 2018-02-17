<?php

namespace CoolVendor\SomeApi\Classes;

class Ticket
{
    public function sendTicket()
    {
        $apiconfigFile = \Mage::getConfig()->getModuleDir('etc', 'CoolVendor_SomeApi').DS.'apiconfig.xml';
        $stringXML = file_get_contents($apiconfigFile);
        $xmlDoc = simplexml_load_string($stringXML, 'Varien_Simplexml_Element');

        $email = $xmlDoc->email_to_send_ticket;

        $emailSendInspect = mail(
                $email,
                "Problem is work",
                "От кого: ".$_POST['username']."\n\n".$_POST['description']
            );      //$data = $this->getRequest()->getPost();

        if($emailSendInspect)
            return true;
        else {
            return false;
        }
    }
}