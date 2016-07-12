<?php

namespace blog\form;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;
use Zend\InputFilter\InputFilter;

class postUploadFrom extends Form {
    public function __construct($name = null) {
        
        parent::__construct($name = 'Post');
        $this->
            setHydrator(new ClassMethodsHydrator(false))
            ->setInputFilter(new InputFilter())
        ;
        
        $this->add(array(
             'name' => 'author',
             'type' => 'Text',
             'options'=>[
                 'label'=>'Author'
             ]
         ));
         $this->add(array(
             'name' => 'title',
             'type' => 'Text',
             'options' => array(
                 'label' => 'Title',
             ),
         ));
         $this->add(array(
             'name' => 'description',
             'type' => 'Text',
             'options' => array(
                 'label' => 'Description',
             ),
         ));
         $this->add([
             'type' => 'Zend\Form\Element\Csrf',
             'name' => 'csrf', 
         ]);
         
         $this->add(array(
             'name' => 'submit',
             'type' => 'Submit',
             'attributes' => array(
                 'value' => 'Submit',
                 'id' => 'submitbutton',
             ),
         ));
    }
}
