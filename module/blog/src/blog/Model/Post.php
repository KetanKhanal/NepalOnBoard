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
   
    protected $id ,$title, $author, $date,$post;
    public function __construct($id,$author,$title,$date,$post) {
        $this->id = $id;
        $this->date = $date;
        $this->author = $author;
        $this->post = $post;
        $this->title = $title;
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
    
}
