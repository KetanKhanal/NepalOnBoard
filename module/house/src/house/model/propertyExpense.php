<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace house\model;

/**
 * Description of propertyExpenses
 *
 * @author User
 */
use Doctrine\ORM\Mapping as ORM;

/** @ORM\Entity */
class propertyExpense {
     /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;
    /** @ORM\Column(type="string") */
    protected $rent;
    /** @ORM\Column(type="string") */
    protected $electricity;
    /** @ORM\Column(type="string") */
    protected $water;
    /** @ORM\Column(type="string") */
    protected $internet;
        /** @ORM\Column(type="string") */
    protected $total;
        /** @ORM\Column(type="string") */
    protected $gas;
    
    public function __construct($options=[]) {
        $this->rent          = $options['rent'];
        $this->electricity   = $options['electricity'];
        $this->water         = $options['water'];
        $this->internet      = $options['internet'];
        $this->gas           = $options['gas'];
        $this->total         = $options['total'];
    }
}
