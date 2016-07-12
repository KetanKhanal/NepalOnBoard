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
use Zend\Filter\Digits as getDigits;
use Zend\Filter\ToInt as number;
use Zend\Filter\BaseName ;
use Zend\View\Helper\HtmlList as htmlList;
use Zend\Validator\StringLength;
use blog\form\postUploadFrom as form;
use blog\Model\Post;
use Zend\Validator\NotEmpty;
use Zend\View\Model\JsonModel as jsonmodel;
use Zend\Filter\PregReplace as replacer;
use Zend\Form\Element;
use Zend\Session\Validator\ValidatorInterface;

class InitialController extends AbstractActionController{
    
    protected $postService;
    protected $posts;
    protected $agent;
    protected $remote;
    public function __construct(PostServiceInterface $postService, ValidatorInterface $httpagent,ValidatorInterface $httpRemote) {
        $this->postService = $postService;
        $this->agent = $httpagent;
        $this->remote = $httpRemote;
    }
    
    public function indexAction() {
        $view = new ViewModel();
        $order = 0;
        $getDigit = new getDigits();
        $check    = (int)$getDigit->filter($this->getRequest()->getUri()->getPath());
        if($this->getRequest()->isGet() && $check !=0 ){
            $this->posts = $this->postService->findAllPosts($check);
        }else {
            $this->posts = $this->postService->findAllPosts(); 
        }
        $authors = [];
        foreach($this->posts as $p){
            $authors[] = $p->getAuthor();
        }
        $modal = new ViewModel();
        $modal->setTemplate('blog/initial/LoginModal');
        $this->layout()->addChild($modal,'loginModal');
        $view->setVariables(['posts'=>$this->posts,'authors'=> array_unique($authors),'pending'=>  Post::PENDING,'approved'=>Post::APPROVED]);
        return $view;
    }
    
    public function showAction(){
        $view       = new ViewModel();
        $getDigit   = new getDigits();
        $id         = $getDigit->filter( $this->getRequest()->getUri()->getPath());
        $post       = $this->postService->findPostById((int)$id);
        $view->setVariables(['post'=>$post]); 
        $this->layout()->setVariables(['show'=>true,'title'=>$post->getTitle(),'id'=>$post->getId(),'description'=>$post->getDes(),'author'=>$post->getAuthor(),'fbId'=>(int)$post->getfbId()]);
        return $view;
    }
    
    public function populateAction(){
        $view   = new ViewModel();
//      $filter = new BaseName();
//      $name = $filter->filter($this->getRequest()->getUriString());
        $name   = $this->getRequest()->getQuery()->name;
        $posts  = $this->postService->findPostByAuthor($name);  
        $view->setVariables(['posts'=>$posts]);
        return $view;
    }
    public function writerAction(){
        $view      = new ViewModel();
        $filter    = new BaseName();
        $remover   = new replacer(['pattern'=>'/-/','replacement'=>' ']);
        $name      = $filter->filter($this->getRequest()->getUriString());
        $finalName = $remover->filter($name);
        $posts = $this->postService->findPostByAuthor($finalName);
        $this->layout()->setVariables(['writer'=>$finalName,'show'=>true]);
        $view->setVariables(['posts'=>$posts,'writer'=>$finalName]);
        return $view;
    }
    
    public function addAction(){
        $view           = new jsonmodel();
        $view->setVariables(['result'=>true,'message'=>'Your Post has been successfully submited']);
        $postData       = $this->getRequest()->getPost();
        $file           = $this->getRequest()->getFiles();
        $httpagent = $this->getRequest()->getServer()['HTTP_USER_AGENT'];
        $remoteaddr = $this->getRequest()->getServer()['REMOTE_ADDR'];
        if (!$this->agent->getData() == $httpagent || !$this->agent->getData()==$remoteaddr){
            return $view->setVariables(['result'=>false,'message'=>'Server seems to have crashed']);
        }
        $titleValidator = new StringLength(['min'=>0,'max'=>50]);
        $descriptionVlaidator = new StringLength(['min'=>0,'max'=>150]);
        $emptyValidator = new NotEmpty();
        if(!$emptyValidator($postData['blogPost']['title']) || !$emptyValidator($postData['blogPost']['content'])|| !$emptyValidator($postData['blogPost']['description'])){
            $view->setVariables(['result'=>false,'message'=>"Please fill all the fields"]);
            return $view;
        }     
        if(!$titleValidator->isValid($postData['blogPost']['title'])){
            $message = 'description cannot excede more than '.$titleValidator->getMax().'characters';
            $view->setVariables(['result'=>false,'message'=>'Title cannot be more than '.$titleValidator->getMax().'charcters']);
            return $view;
        }
        if(!$descriptionVlaidator->isValid($postData['blogPost']['description'])){
            $message = 'description cannot excede more than '.$descriptionVlaidator->getMax().'characters';
            $view->setVariables(['result'=>false,'message'=>'Description cannot be more than '.$descriptionVlaidator->getMax().' characters']);
            return $view;
        }
        $post= new Post([
            'id'            => null,
            'author'        => $postData['blogPost']['author'],
            'title'         => $postData['blogPost']['title'],
            'date'          => $postData['blogPost']['date'],
            'content'       =>$postData['blogPost']['content'],
            'description'   => $postData['blogPost']['description'],
            'fbId'          => $postData['blogPost']['fbId'],
            'post'          => '',
            'status'        =>Post::DEFAULT_STATUS
        ]);
        $post->setImage($file);
        $resultFromSave =$this->postService->save($post) ;
        if(!$resultFromSave[Post::RESULT]){
            $view->setVariables(['result'=>false,'message'=>$resultFromSave[Post::MESSAGE]]);
            return $view;
        }
        return $view;
    }
    
}
