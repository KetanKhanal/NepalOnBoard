<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of user
 *
 * @author User
 */
namespace house\model ;

use Doctrine\ORM\Mapping as ORM;
/** @ORM\Entity */
class user   {
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;
    /** @ORM\Column(type="string") */
    protected $firstName;
    /** @ORM\Column(type="string") */
    protected $lastName;
    /** @ORM\Column(type="string") */
    protected $email;
    /** @ORM\Column(type="string") */
    protected $dateOfBirth;
    /** @ORM\Column(type="string") */
    protected$userType;
    /** @ORM\Column(type="string") */
    protected $nationality;
    /** @ORM\Column(type="string") */
    protected $fbId;
     /** @ORM\Column(type="integer") */
    protected $property_id;
    
    public function __construct($options=null) {
        if(!$options['id'] == null){
            $this->id=$options['id'];
        }
        $this->firstName   = $options['firstName'];
        $this->lastName    = $options['lastName'];
        $this->email       = $options['email'];
        $this->dateOfBirth = $options['dateOfBirth'];
        $this->userType    = $options['userType'];
        $this->fbId        = $options['fbId'];
        $this->nationality = $options['nationality'];
        $this->property    = $options['property_id'];
    }
    public function id($id=null){
       if($id==null){
           return $this->id;
       }
       $this->id =$id;
    }
    public function firstName($firstName=null){
       if($firstName==null){
           return $this->firstName;
       }
       $this->firstName =$firstName;
    }
    public function lastName($lastName=null){
       if($lastName==null){
           return $this->lastName;
       }
       $this->lastName =$lastName;
    }
    public function email($email=null){
       if($email==null){
           return $this->email;
       }
       $this->email =$email;
    }
    public function nationality($nationality = null){
         if($nationality==null){
           return $this->nationality;
       }
       $this->nationality =$nationality;
    }
    public function userType($userType = null){
         if($userType==null){
           return $this->userType;
       }
       $this->userType =$userType;
    }
    public function dob($dob = null){
         if($dob==null){
           return $this->dateOfBirth;
       }
       $this->dateOfBirth =$dob;
    }
     public function fbId($fbId = null){
         if($fbId==null){
           return $this->fbId;
       }
       $this->fbId =$fbId;
    }
}
