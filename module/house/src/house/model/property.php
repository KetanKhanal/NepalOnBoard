<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of property
 *
 * @author User
 */
namespace house\model;
use Doctrine\ORM\Mapping as ORM;
use house\model\houseModel;
/** @ORM\Entity */
class property  {
   /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
   protected $id;
   /** @ORM\Column(type="string") */
   protected $type;
   /** @ORM\OneToOne(targetEntity="propertyAddress") */
   protected $address;
   /** @ORM\Column(type="string") */
   protected $description;
   /** @ORM\Column(type="string") */
   protected $status;
    /** @ORM\OneToOne(targetEntity="propertyExpense") */
   protected $expenses;
    /** @ORM\Column(type="string") */
   protected $avaliableFrom;
   /** @ORM\OneToOne(targetEntity="propertyImages") */
   protected $propertyImages;
   public function __construct($options=[]) {
        if(!$options['id'] == null){
            $this->id=$options['id'];
        }
        $this->type        = $options['type'];
        $this->address     = $options['address'];
        $this->expenses        = $options['expenses'];
        $this->description   = $options['description'];
        $this->status      = $options['status'];
        $this->availableFrom = $options['availableFrom'];
        $this->propertyImages = $options['propertyImages'];
    }
    
     public function id($id=null){
       if($id==null){
           return $this->id;
       }
       $this->id =$id;
    }
     public function type($type=null){
       if($type==null){
           return $this->type;
       }
       $this->type =$type;
    }
     public function address(propertyAddress $address=null){
       if($address==null){
           return $this->address;
       }
       $this->address =$address;
    }
     public function user(user $user=null){
       if($user==null){
           return $this->user;
       }
       $this->user =$user;
    }
     public function description($description=null){
       if($description==null){
           return $this->description;
       }
       $this->description =$description;
    }
    public function status($status=null){
       if($status==null){
           return $this->status;
       }
       $this->status =$status;
    }
    public function expenses(propertyExpense $exp = null){
        if($exp==null){
           return $this->expenses;
        }
       $this->expenses =$exp;
    }
    
    public function propertyImages(propertyImages $imgs = null){
        if($imgs ==null){
            return $this->propertyImages;
        }
        $this->propertyImages = $imgs;
    }
}
