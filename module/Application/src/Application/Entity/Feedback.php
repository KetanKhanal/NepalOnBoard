<?php


/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Feedback
 *
 * @author User
 */
namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Db\TableGateway as tableGateway;
class Feedback {
    private $name;
    private $email;
    private $message;
    
    public function name($name = null){
        if(is_null($name)){
            return $this->name;
        }
        $this->name = $name;
    }
    public function email($email = null){
        if(is_null($email)){
            return $this->email;
        }
        $this->email = $email;
    }
    public function message($message = null){
        if(is_null($message)){
            return $this->message;
        }
        $this->message = $message;
    }
}
