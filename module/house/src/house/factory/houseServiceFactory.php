<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace house\factory;

/**
 * Description of houseServiceFactory
 *
 * @author User
 */
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use house\service\houseService;
class houseServiceFactory implements FactoryInterface {
    public function createService(ServiceLocatorInterface $serviceLocator) {
        $objectManager      = $serviceLocator->get('Doctrine\ORM\EntityManager');
        return new houseService($objectManager);
    } 
}
