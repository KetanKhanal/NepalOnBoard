<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace house\logic;
use house\logic\job;
use house\service\houseService;
use house\model\user;
/**
 * Description of addJob
 *
 * @author User
 */
class addJob implements job {
    const POSTDATA  = 0;
    const IMAGEDATA = 1;
    public $houseService   = '';
    public function myJob($data,houseService $houseService) {
        $imageData = '';
        $postData  = '';
        if(is_array($data)){
            $postData  = $data[self::POSTDATA];
            $imageData = $data[self::IMAGEDATA];
        } else {
            $postData = $data;
        }
        $this->houseService = $houseService;
        makeProperty($postData);
        makeImage($imageData);
    }
    
    public function makeProperty($postData){
        //make user if it does not exist 
        //save property 
    }
    
    public function makeImage($imageData){
        //save image
    }
}
