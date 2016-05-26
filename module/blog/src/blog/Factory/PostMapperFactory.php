<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace blog\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use blog\Mapper\PostMapper;
use Zend\Db\Adapter\Adapter;
class PostMapperFactory implements FactoryInterface {
    
    public function createService(ServiceLocatorInterface $serviceLocator) {

        $adapter        = $serviceLocator->get('db2');
       
        return new PostMapper($adapter);
    } 
}
