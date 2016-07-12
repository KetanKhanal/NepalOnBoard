<?php

namespace blog\utils;
use Zend\Mail\Message as message;
use Zend\Mail\AddressList;
use Zend\Mail\Transport\Sendmail as sendmail;
use Zend\Mime\Part as mimePart;
use Zend\Mime\Message as mimeMessage;
class mailGenerator {
    public static function GENERATEEMAIL($email){
        $message = new message();
        $message->setFrom("service@nepalonboard.com");
        $message->setTo($email);
        $addr = new AddressList();
        $addr->add('ketan.khanal@y7mail.com','Ketan');
        $message->setSubject("Blog Post");
        $message->setBcc($addr);
        $text = new mimePart('<p>Hi,<br/><br/>Thank you for writing a blog article at Nepal Onboard. The article will be reviewd and made public with in one hour if it is fine. We will let you know once it has been reviewd.</p><h4>Sincerly,</h4><h4>Nepal Onboard</h4><div><img style="width:100px;height:100px;" src="http://nepalonboard.com/img/newnobsmall.png"/> </div>');
        $text->setType('text/html');
        $body = new mimeMessage();
        $body->setParts([$text]);
        $message->setBody($body);
        $transport = new sendmail();
        $transport->send($message);
    }
    
  
        
        
    
}
