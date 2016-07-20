<?php
/**
 * Description of PostService 
 * 
 *  This class actually lets us manipulate data and play with the data.
 * @author User
 */

namespace blog\Service;

use blog\Service\PostServiceInterface;
use blog\Model\Post;
use blog\Mapper\DataMapperInterface;
class PostService implements PostServiceInterface {
    
    protected $postMapper;
    
    public function __construct(DataMapperInterface $postMapper) {
        $this->postMapper = $postMapper;
    }
    
    public function findAllPosts($order = 0,$pending=false) {
       $posts = $this->postMapper->findAll($order,$pending);
       return $posts;
    }
    
    public function findPostById($id) {
       $post = $this->postMapper->findById($id);
       return $post;
    }
    public function findPostByAuthor($name){
        $post = $this->postMapper->findByAuthor($name);
        return $post;
    }
    public function deletePost(){}
    public function save($post){
       return $this->postMapper->save($post);
    }
}
