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
use Zend\Session\Validator\HttpUserAgent;
use Zend\Session\Validator\RemoteAddr;
class InitialControllerFactory implements FactoryInterface {
    
    /*Returns an instance of classs initial controller with postservice type class initialised in it*/
    public function createService(ServiceLocatorInterface $serviceLocator) {
        var_dump('suk');
        die();
        $realServiceLocator = $serviceLocator->getServiceLocator();
        $postService        = $realServiceLocator->get('blog\Service\PostServiceInterface');
        $HttpUserAgent = new HttpUserAgent();
        $HttpRemote    = new RemoteAddr();
        return new InitialController($postService,$HttpUserAgent,$HttpRemote);
    } 
}
