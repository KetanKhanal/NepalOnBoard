<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of fileSaver
 *
 * @author User
 */
namespace blog\utils;
use Zend\Validator\File\Size;
use Zend\Validator\File\Extension;
class fileSaver {
    
    /*This static function saves image file for blog post*/
    public static  function SAVEFILE($file,$postid){
        $filename          = $file['file'][0]['name'];//take the filename from http $_file request $file
        $extension         = pathinfo($filename, PATHINFO_EXTENSION);// check the extension of the filename
        $newname           = 'post'.$postid;//create new name for the file
        $new               = $newname.'.'.$extension;//add the extension to the new file name
        /*Use zend validator class to check the size of the image*/
        $imageSizeValidator = new Size([
            'max'=>'2MB' // allow maimum size one mb
        ]); 
        
        /*Use zend image type validator to check the type of the image*/
        $imageTypeValidator = new Extension([
            'case'=>true,
            'extension'=>[
                'jpg','jpeg'
            ]
        ]);
        /*Use php function getcwd to get the main working directory*/
        $path = getcwd() . '/public/img/posts/'.$new;    
        
        /*check to see if the file size is less that equal to allowed size*/
        if(!$imageSizeValidator->isValid($file['file'][0])){
            return [false,'Sorry! the file size is more than '.$imageSizeValidator->getMax()];
        }
        /*check to see if the type of the file is allowed*/
        if(!$imageTypeValidator->isValid($file['file'][0])){
            return [false,'Sorry! only .jpg files are allowed'];
        }
        
        
        
        /*if everything goes according to planed then move the uploaded file from temp directory to the the image folder.
          return flase on error with error message. */
        if( !move_uploaded_file($file['file'][0]['tmp_name'],$path)){
            return [false,'file could not be loaded at this time'];
        }
        
        /*If everything is valid then return true with empty message.*/
        return [true,''];
    }
}
