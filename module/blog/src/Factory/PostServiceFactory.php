<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace blog\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;
use blog\Service\PostService;

/**
 * Description of PostServiceFactory
 *
 * @author User
 */
class PostServiceFactory implements FactoryInterface{

    public function createService(ServiceLocatorInterface $serviceLocator) {

        $postMapper         = $serviceLocator->get('blog\Mapper\DataMapperInterface');
        return new PostService($postMapper);
    } 
}
