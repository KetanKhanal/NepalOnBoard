<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of addLogic
 *
 * @author User
 */
namespace house\logic;

use house\service\houseService;
use house\logic\job;
class addLogic implements logic{
    private  $houseService;
    public function __construct( houseService $houseService){
        $this->houseService = $houseService;
    }
    public function handleLogic($data,job $jobClass){
        $jobClass->myJob ($data,$this->houseService);
        return true;
    }
}
