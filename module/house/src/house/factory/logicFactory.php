<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace house\factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use house\service\houseService;
use house\logic\addLogic;
class logicFactory implements FactoryInterface {
    public function createService(ServiceLocatorInterface $serviceLocator) {
        $service    = $serviceLocator->get('house\service\houseService');
        return new addLogic($service);
    } 
}
