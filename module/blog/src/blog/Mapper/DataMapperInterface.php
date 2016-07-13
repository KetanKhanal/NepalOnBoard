<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author User
 */
namespace blog\Mapper;

interface DataMapperInterface {
    
    public function findAll($order,$pending);
    public function findById($id);
    public function findByAuthor($name);
    public function save($item);
    public function delete();
    
}
