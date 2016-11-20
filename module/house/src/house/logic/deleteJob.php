<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace house\logic;
use house\logic\job;
/**
 * Description of deleteJob
 *
 * @author User
 */
class deleteJob implements job{
    public function myJob() {
        return 'I delete things';
    }
}
