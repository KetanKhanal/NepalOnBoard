<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of propertyAddress
 *
 * @author User
 */

namespace house\model;

use Doctrine\ORM\Mapping as ORM;
/** @ORM\Entity */
class propertyAddress {
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;
      /** @ORM\Column(type="string") */
    protected $unit;
      /** @ORM\Column(type="string") */
    protected $street;
      /** @ORM\Column(type="string") */
    protected $suburb;
      /** @ORM\Column(type="string") */
    protected $state;
      /** @ORM\Column(type="string") */
    protected $postcode;
    public function __construct($options=[]) {
        if(!$options['id'] == null){
            $this->id=$options['id'];
        }
        $this->unit        = $options['unit'];
        $this->street     = $options['street'];
        $this->suburb        = $options['suburb'];
        $this->state   = $options['state'];
        $this->postcode      = $options['postcode'];
    }
}
