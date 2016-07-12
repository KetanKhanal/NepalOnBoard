<?php

namespace Application\utilities;

use Zend\Mail\Message as message;
use Zend\Mail\Transport\Sendmail as sendmail;
use Zend\Mime\Part as mimePart;
use Zend\Mime\Message as mimeMessage;
class mailGenerator {
    public static function GENERATEEMAIL($email){
        $message = new message();
        $message->setFrom("service@nepalonboard.com");
        $message->setTo($email);
        $message->setSubject("Welcome to the family");
        $text = new mimePart('<p>Hi,<br/><br/>Thank you for being a part of Nepal Onboard. We value your interest and we will inform you when we go live.</p><h4>Sincerly,</h4><h4>Nepal Onboard</h4><div><img style="width:100px;height:100px;" src="http://nepalonboard.com/img/newnobsmall.png"/> </div>');
        $text->setType('text/html');
        $body = new mimeMessage();
        $body->setParts([$text]);
        $message->setBody($body);
        $transport = new sendmail();
        $transport->send($message);
    }
    
  
        
        
    
}
