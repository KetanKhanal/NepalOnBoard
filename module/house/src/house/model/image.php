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

/** @ORM\Entity */
class image {
   /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
   protected $id;
   /** @ORM\Column(type="string") */
   protected $name;
   /** @ORM\OneToOne(targetEntity="propertyAddress") */
   protected $mimeType;
   /** @ORM\Column(type="string") */
   protected $size;
    /** @ORM\OneToOne(targetEntity="imageDescription") */
   protected $description;
           
   public function __construct($options=[]) {
        if(!$options['id'] == null){
            $this->id=$options['id'];
        }
        $this->id          = $options['id'];
        $this->name        = $options['name'];
        $this->mimeType     = $options['mimeType'];
        $this->size        = $options['size'];
        $this->description   = $options['description'];
        $this->status      = $options['status'];
        $this->availableFrom = $options['availableFrom'];
    }
}
