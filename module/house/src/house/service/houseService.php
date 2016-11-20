<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of houseService
 *
 * @author User
 */
namespace house\service;
use Doctrine\ORM\EntityManager;
use house\model\houseModel;
class houseService {
    protected $objectManager;
    public function  __construct(EntityManager $manager){
       $this->objectManager = $manager;
    }
    public function getObjectManger(){
       return $this->objectManager;
    }
    public function save($entity){
       $this->objectManager->persist($entity);
       $this->objectManager->flush();
    }
    public function delete($entity){
        $this->objectManager->remove($entity);
        $this->objectManager->flush();
    }
    public function fetchAll($entity){
     $entities = $this->objectManager->getRepository(get_class($entity))->findAll(); 
     return $entities;
    }
    public function fetch($entity){
        return $this->objectManager->find(get_class($entity), $id);
    }
}
