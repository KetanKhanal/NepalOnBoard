<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Module
 *
 * @author User
 */

namespace blog;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;

class Module implements AutoloaderProviderInterface, ConfigProviderInterface {
    public function getConfig(){
        /**Instead of writing a long configuration in this function we are going to load configuration from another file in the 
        same module folder.A file called module.cofig.php**/
         return include __DIR__ . '/config/module.config.php';
    }
    
     public function getAutoloaderConfig(){
        return [
            'Zend\Loader\StandardAutoloader' => [
                'namespaces' => [
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ],
            ],
        ];
    }
}
