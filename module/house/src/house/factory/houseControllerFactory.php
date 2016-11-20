<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of houseControllerFactory
 *
 * @author User
 */
namespace house\factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use house\Controller\houseController;
use house\logic\addLogic;
class houseControllerFactory implements FactoryInterface {
     /*Returns an instance of classs initial controller with postservice type class initialised in it*/
    public function createService(ServiceLocatorInterface $serviceLocator) {
        $realServiceLocator = $serviceLocator->getServiceLocator();
        $logic              = $realServiceLocator->get('house\logic\addLogic');
        return new houseController($logic);
    } 
}
