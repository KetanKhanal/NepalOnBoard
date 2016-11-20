<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace house\logic;
use house\service\houseService;
/**
 *
 * @author User
 */
interface job {
   
    public function myJob($data, houseService $houseService);
}
