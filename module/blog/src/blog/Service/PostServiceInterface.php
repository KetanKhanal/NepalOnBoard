<?php

namespace blog\Service;

interface PostServiceInterface {
    
    public function findAllPosts();
    public function findPostByAuthor($name);
    public function findPostById($id);
    public function save($post);
}
