<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use \Zend\View\View;
use Zend\View\Helper\Layout;
use Zend\View\Model\JsonModel as jsonmodel;
use Zend\Validator\EmailAddress as emailvalidator;
use Zend\Validator\NotEmpty;
use Zend\Db\TableGateway\TableGateway as tablegateway;
use Application\utilities\mailGenerator as mail;
use DateTime;
class InitialController extends AbstractActionController
{  
    protected $feedbackTable;
    protected $subscriptionTable;
    const INSERT = 'insert';
    const UPDATE = 'update';
    const TABLES = ['feedback'=>'feedbackTable','subscription'=>'subscriptionTable'];
    public function indexAction()
    {
        $view     = new ViewModel();
        $this->layout()->setTemplate('layout/baseInterface');
        $currentUrl=$this->getRequest()->getUriString();
        $dateTime = new DateTime();
        $dateTime->setDate('2016','06','23');
        $view->setVariables(['currentUrl'=>$currentUrl,'currentDate'=>$dateTime->format('Y')]);
        return $view;
        
    }
    
      public function addAction(){
       $view            = new jsonmodel();
       $email           = $this->getRequest()->getPost();
       $emailValidator  = new emailvalidator();
       $emptyValidator  = new NotEmpty();

       $subData         = $this->getTable('subscription')->select();
       $continue        = true; 
       $action          = '';
       $fieldToUpdateId = '';
       
       $isGiven = $emptyValidator->isValid($email->email);
       if( !$emailValidator->isValid($email->email)  ){
        $view->setVariables(['result'=>false,'message'=>$emailValidator->getMessages()]);  
        $continue = false;
       } 
       if(!$isGiven){
        $view->setVariables(['result'=>false,'message'=>$emptyValidator->getMessages()]);
        $continue = false;
       }
       if($continue){
            foreach($subData as $subscription){  
                if($subscription->email === $email->email){
                    $action = 'update';
                    $fieldToUpdateId = $subscription->id;
                } 
            }
       }
       if($action === self::UPDATE){
           $this->getTable('subscription')->update(['email'=>$email->email],['id'=>$fieldToUpdateId]);
           $view->setVariables(['result'=>true,'message'=>'OOPS Looks like we already have your email address']);
       }
       
      if($action === '' && $continue){
          $this->getTable('subscription')->insert((array)$email);
          $view->setVariables(['result'=>true,'message'=>"Yes the job is done"]);
      }
       if($view->getVariable('result')){
           mail::GENERATEEMAIL($email);
       };
       return $view;
    }
    
    
    public function getTable($table){
        $tobring = self::TABLES;
        $tobringTable = $tobring[$table];
        
        if (!$this->$tobringTable) {
            $sm = $this->getServiceLocator();
            $this->$tobringTable = new tablegateway(
                    $table,$sm->get('Zend\Db\Adapter\Adapter')
            );
                             
         }
         return $this->$tobringTable;
    }
    
    public function messageAction() {
       $view           = new jsonmodel();
       $this->layout()->setTemplate('layout/baseInterface');            
       $feedback       = $this->getRequest()->getPost();
       $feedbackData   = $this->getTable('feedback')->select();
       $notPresent     = true;
       $saved          = null; 
       $emailValidator = new emailvalidator();
       $notValidator   = new NotEmpty();
       $continue       = true;
       $dataToUpdate   = null;
       
       // If the email is given but the given email is not of email format then do this
       if($notValidator->isValid($feedback->feedback['email']) 
          && !$emailValidator->isValid($feedback->feedback['email'])
        ){
           $view->setVariables(['result'=>false,'message'=>$emailValidator->getMessages()]);
           $continue = false;
       }
       //If any one of the given fields are empty then do this
       if(!$notValidator->isValid($feedback->feedback['name']) 
          || !$notValidator->isValid($feedback->feedback['email']) 
          ||!$notValidator->isValid($feedback->feedback['message']) 
        ){
           $view->setVariables(['result'=>false,'message'=>$notValidator->getMessages()]);
           $continue = false;
       }   
       if($continue){
            foreach($feedbackData as $feeds){
                if($feeds->email === $feedback->feedback['email']){
                    $notPresent   = false;
                    $dataToUpdate = $feeds->id; 
                }
            }
            if($notPresent){
             $saved = $this->getTable('feedback')->insert($feedback->feedback);
            } else {   
             $saved = $this->getTable('feedback')->update(['message' => $feedback->feedback['message']],['id' => $dataToUpdate]);
            }
            $view->setVariables(["result"=>true,'message'=>'Your message has been posted']);
       }
       
       return $view;
    }
    public function editAction(){   
    }
    
    public function deleteAction(){
    }
    
    
}
