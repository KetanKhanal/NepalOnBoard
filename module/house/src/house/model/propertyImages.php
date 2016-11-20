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
class propertyImages {
   /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
   protected $id;
   
    /** @ORM\OneToOne(targetEntity="image") */
   protected $img1;
   /** @ORM\OneToOne(targetEntity="image") */
   protected $img2;
   /** @ORM\OneToOne(targetEntity="image") */
   protected $img3;
  /** @ORM\OneToOne(targetEntity="image") */
   protected $img4;
   /** @ORM\OneToOne(targetEntity="image") */
   protected $img5;
   public function __construct($options=[]) {
        if(!$options['id'] == null){
            $this->id=$options['id'];
        }
        $this->img1          = $options['img1'];
        $this->img2        = $options['img2'];
        $this->img3     = $options['img3'];
        $this->img4        = $options['img4'];

    }
}
