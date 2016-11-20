<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace house\logic;

/**
 *
 * @author User
 */
use house\service\houseService;
use house\logic\job;
interface logic {
    public function __construct(houseService $service);
    public function handleLogic($data,job $job);
}
