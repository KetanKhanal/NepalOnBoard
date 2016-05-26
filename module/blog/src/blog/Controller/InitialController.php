<?php
/**
 * When people click on article in application module they are routed to index action of initial controller of the blog
 * Since this class has a parameterised constructor, we need to let our controller manager in the module know that it has 
 * to route to a factory class which will return an instance of this class with the PostService embedded in it. 
 *
 * @author Ketan
 */

namespace blog\Controller ;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use blog\Service\PostServiceInterface;
class InitialController extends AbstractActionController{
    
    protected $postService;
    
    public function __construct(PostServiceInterface $postService) {
        $this->postService = $postService;
    }
    
    public function indexAction() {
        $view = new ViewModel();
        $view->setVariables(['posts'=>$this->postService->findAllPosts()]);        
        return $view;
    }
    
    public function addAction(){
        
    }
    
    public function deleteAction(){
        
    }
    
    public function updateAction(){
        
    }
}
