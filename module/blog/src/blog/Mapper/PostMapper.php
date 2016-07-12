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
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;
use Zend\Db\Sql\Insert;
use Zend\Filter\PregReplace as replacer;
use blog\utils\fileSaver as fsaver;
class PostMapper implements DataMapperInterface {
    protected $adapter;
    private $postTable;
    protected $name;
    /*Beauty of factory pattern is that it initialises a particular class anonomously.*/
    public function __construct(AdapterInterface $adapter) {
        $this->adapter = $adapter;
    }
    /*This function gets the post table from the database. Uses db adapter which is initialised with the required db name
       by postmapper factory     */
    public function theTable(){
        if (!$this->postTable) {
            $this->postTable = new TableGateway('post',$this->adapter);                 
         }
         return $this->postTable;
    }
    /*Returns all the posts in post table that have status approved.*/
    public function findAll($order) {
      $posts = [];
      $thePosts = ($order != 0 && $order == 1)?$this->theTable()->select(function(Select $select){$select->order('id DESC');$select->where->like('status',  Post::APPROVED);}):$this->theTable()->select();
      if($order != 0 && $order==2){
          $thePosts = $this->theTable()->select(function(Select $select){$select->order('title ASC');$select->where->like('status',Post::APPROVED);});
      }
      foreach($thePosts as $data){
          $posts[] = $this->findById($data->id);
      }
      return $posts;
    }
    
    /*Searches post table by a single unique id*/
    public function findById($id) {
       $data      = $this->theTable()->select(['id'=>$id]);
       $fileToGet = __DIR__.'/../posts/post'.$id.".json";
       $file = json_decode(file_get_contents($fileToGet));
       $postArray = [
            'id'    => $data->current()->id,
            'author'=> $data->current()->author,
            'title' => $data->current()->title,
            'date'  => $data->current()->date,
            'content'=>$file->content,
            'description' =>$file->description,
            'fbId'=> $file->fb_id,
            'post'=> $data->current()->post,
            'status'=>$data->current()->status
       ];
       $post      = new Post($postArray);
       return $post;
    }
    public function findByAuthor($namer){
       $this->name = '%'.$namer.'%'; // author name to search the database for
       $posts = [];//initialise an array to store posts
       /*Select all the posts from posts table with author $namer*/
       $thePosts = $this->theTable()->select(function(Select $select){
           $select->where->like('author',$this->name)->like('status',  Post::APPROVED);  
           
       });
       /*add all the row into the posts array */
        foreach($thePosts as $data){
          $posts[] = $this->findById($data->id);
        }
        
        return $posts;// return the posts array 
    }
    public function save($post){
        $remover   = new replacer(['pattern'=>'/\r?\n/','replacement'=>'</br>']);//Replaces paragraph change from the form to html br to store it as json object
        $id=[];//initialising id variable
        /*The last post variable is the last data in the table post. To check id of last post*/
        $theLastPost = $this->theTable()->select(function(Select $select){
            $select->order('id DESC');
            $select->limit(1);
        });
        /*Adding the last post id into the id variable*/
        foreach($theLastPost as $posti){
            $id[]=(int)$posti->id;
        } 
        /*The new posts id is going to be the last post plus one*/
        $idToget = $id[0]+1;
        $resultFromFileSaver  = fsaver::SAVEFILE($post->getImage(),$idToget);//f saver saves the image entered by the writer
        if(!$resultFromFileSaver[Post::RESULT]){
            return [false,$resultFromFileSaver[Post::MESSAGE]]; // fsaver returns an array with two variables result message
        }
        $fileToGet = __DIR__.'/../posts/post'.$idToget.".json";//the directory to save the json data
        $content = $remover->filter($post->getContent());// this line replaces paragraph change with br tag
        $stringVariable = json_encode(['content'=>$content,'description'=>$post->getDes(),'fb_id'=>$post->getfbId()]);//changes strings from form into json format
        file_put_contents($fileToGet, $stringVariable);// php function file_put_contents overwrites the file or creates a new one if the file is not available.
        // required data array holds seperated form data to store in the database
        $RequiredData = [
            'id' =>$post->getId(),
            'author'=>$post->getAuthor(),
            'date'=>$post->getDate(),
            'category'=>2,
            'post'=>'',
            'title'=>$post->getTitle(),
            'status'=>$post->getStatus()
        ];        
        /*saves required data into the database.If theres an error deletes respective json file and the image file that 
          has been created*/
        if(!$this->theTable()->insert($RequiredData)){
            //delete the files 
            return[false,'Server Error'];    
        }
        
        return [true,'success'];// if everything goes according to the plan then return success
    }
    public function delete(){
        
    }
}
