<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace house\model;

/**
 * Description of booking
 *
 * @author User
 */
use Doctrine\ORM\Mapping as ORM;
/** @ORM\Entity */
class booking extends houseModel{
     /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;
    /** @ORM\OneToMany(targetEntity="user") */
    protected $user;
    /** @ORM\OneToMany(targetEntity="property") */
    protected $property;
     /** @ORM\Column(type="string") */
    protected $date;
    /** @ORM\Column(type="string") */
    protected $time;
    public function __construct($options=[]) {
        if(!$options['id'] == null){
            $this->id=$options['id'];
        }
        $this->user        = $options['user'];
        $this->property    = $options['property'];
        $this->date        = $options['date'];
        $this->time        = $options['time'];
    }
}
