<?php

namespace blog\Service;

interface PostServiceInterface {
    
    public function findAllPosts();
    
    public function findPostById($id);
}
