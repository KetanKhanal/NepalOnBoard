<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PostMapper
 *
 * @author User
 */
namespace blog\Mapper;

use blog\Mapper\DataMapperInterface;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\TableGateway\TableGateway;
use blog\Model\Post;
class PostMapper implements DataMapperInterface {
    
    protected $adapter;
    private $postTable;

    public function __construct(AdapterInterface $adapter) {
        $this->adapter = $adapter;
    }
    
    public function theTable(){
        if (!$this->postTable) {
            $this->postTable = new TableGateway('post',$this->adapter);                 
         }
         return $this->postTable;
    }
    public function findAll() {
      $posts = [];
      foreach($this->theTable()->select() as $data){
          $posts[] = $this->findById($data->id);
      }
      return $posts;
    }
    
    public function findById($id) {
       $data      = $this->theTable()->select(['id'=>$id]);
       $post      = new Post($data->current()->id,$data->current()->author,$data->current()->title,$data->current()->date,$data->current()->post);
       return $post;
    }
    
    public function save(){
        
    }
    public function delete(){
        
    }
}
