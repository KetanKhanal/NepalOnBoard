<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of InitialControllerFactory
 *
 * This class adds PostService to the initial controller and returns an instance of it. 
 * @author User
 */
namespace blog\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use blog\Controller\InitialController;
class InitialControllerFactory implements FactoryInterface {
    
    public function createService(ServiceLocatorInterface $serviceLocator) {
        $realServiceLocator = $serviceLocator->getServiceLocator();
        $postService        = $realServiceLocator->get('blog\Service\PostServiceInterface');
        
        return new InitialController($postService);
    } 
}
