<?php
/**
 * When people click on article in application module they are routed to index action of initial controller of the blog
 * Since this class has a parameterised constructor, we need to let our controller manager in the module know that it has 
 * to route to a factory class which will return an instance of this class with the PostService embedded in it. 
 *
 * @author Ketan
 */

namespace house\Controller ;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use house\util\loadCities;
use house\service\houseService;
use house\model\user;
use house\logic\logic;
use house\logic\addJob;
use house\logic\deleteJob;
use house\logic\updateJob;
class houseController extends AbstractActionController{
    const COUNTRY = 'country';
    const TEMPLATES = [
      "address","information","expenses","pictures","detail","personal","verification","final" 
    ];
    private $logic;
    public function __construct(logic $logic) {
        $this->logic = $logic;
    }
    public function indexAction() {
        $view  = new ViewModel();
        $this->layout()->setTemplate('layout/houselayout');
        $temp1 = new ViewModel();
        $temp1->setTemplate('/templates/address');
        $temp2 = new ViewModel();
        $temp2->setTemplate('/templates/information');
        $temp3 = new ViewModel();
        $temp3->setTemplate('/templates/expenses');
        $temp4 = new ViewModel();
        $temp4->setTemplate('/templates/pictures');
        $temp6 = new ViewModel();
        $temp6->setTemplate('/templates/personal');     
        $temp5 = new ViewModel();
        $temp5->setTemplate('/templates/detail');
        $temp7 = new ViewModel();
        $temp7->setTemplate('/templates/verification');  
        $temp8 = new ViewModel();
        $temp8->setTemplate('/templates/final');
        $modal1 = new ViewModel();
        $modal1->setTemplate('house/hostModal');
        $modal2 = new ViewModel();
        $modal2->setTemplate('house/LoginModal');
        $modal1->setVariables(['temps'=>self::TEMPLATES]);
        $modal1->addChild($temp1,'address');
        $modal1->addChild($temp2,'information');
        $modal1->addChild($temp3,'expenses');
        $modal1->addChild($temp4,'pictures');
        $modal1->addChild($temp5,'detail'); 
        $modal1->addChild($temp6,'personal');
        $modal1->addChild($temp7,'verification');
        $modal1->addChild($temp8,'final');
        $view->addChild($modal1,'hostModal');  
        $view->addChild($modal2,'signModal');
        return $view;
    }
    /*The function below returns a list of cities for the country that is received as get query
     */
    public function loadAction(){
        $view    = new JsonModel();
        $country = $this->getRequest()->getQuery(self::COUNTRY);
        $cities  = new loadCities($country);
        $view->setVariables($cities->getCities());
        return $view;
    }
    public function addAction(){
        $view = new JsonModel();
        $postData       = $this->getRequest()->getPost();
        $img            = $this->getRequest()->getFiles();
        $postData       = json_decode(json_encode(json_decode($postData['data'])));
        if(!$this->logic->handleLogic([$postData,$img],new addJob())){   
            
        }
        return $view;
    }
    public function deleteAction(){
        if(!$logic->handleLogic($PostData,new deleteJob())){
         
        }
    }
    public function updateAction(){
        if(!$logic->handleLogic($PostData,new updateJob())){
          
        }
    }
    private function getLogic(){
        return $this->logic;
    }
}