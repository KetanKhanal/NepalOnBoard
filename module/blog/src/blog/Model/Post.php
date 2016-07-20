<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Post
 *
 * @author User
 */

namespace blog\Model;
use blog\Model\NobModelInterface;
use blog\Model\NobModel;

class Post implements NobModelInterface,  NobModel {
    
    const PENDING        = 'pending';
    const DEFAULT_STATUS = self::PENDING;
    const APPROVED       = 'approved';
    const MESSAGE = 1;
    const RESULT =0;
    const DEFAULT_ORDER = 2;
    protected $id ,$title, $author, $date,$post,$image,$content,$description,$fbId,$status;
    public function __construct($options=[]) {
        if(!$options['id'] == null){
            $this->id=$options['id'];
        }
        $this->date = $options['date'];
        $this->author = $options['author'];
        $this->post = $options['post'];
        $this->title = $options['title'];
        $this->content= $options['content'];
        $this->description= $options['description'];
        $this->fbId = $options['fbId'];
        $this->status= $options['status'];
    }
    public function getId() {
        return $this->id;
    }
    public function getTitle(){
        return $this->title;
    }
    public function getAuthor(){
        return $this->author;
    }
    public function getDate() {
        return $this->date;
    }
    public function getPost() {
        return $this->post;
    }
    public function getImage(){
        return $this->image;
    }
    public function setImage($image){
        $this->image = $image;
    }
    public function getContent(){
        return $this->content;
    }
    public function getDes(){
        return $this->description;
    }
    public function getfbId(){
        return $this->fbId;
    }
     public function getStatus(){
        return $this->status;
    }
    public function setStatus($status){
       $this->status = $status;
    }

}
