<?php

namespace house;

return [
        'doctrine' => array(
        'driver' => array(
            // defines an annotation driver with two paths, and names it `my_annotation_driver`
            'my_annotation_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(
                   __DIR__ . '/../src/house/model'
                ),
            ),

            // default metadata driver, aggregates all other drivers into a single one.
            // Override `orm_default` only if you know what you're doing
            'orm_default' => array(
                'drivers' => array(
                    // register `my_annotation_driver` for any entity under namespace `My\Namespace`
                    'house\model' => 'my_annotation_driver'
                )
            )
        )
    ),
    'router' => [
        'routes' => [
            'house' => [
                'type' => 'Segment',
                'options' => [
                    'route'    => '/house[/]',
                    'defaults' => [
                        '__NAMESPACE__' => 'house\Controller',
                        'controller' => 'house',
                        'action'     => 'index',
                    ]
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'load' => [
                        'type'    => 'Segment',
                        'options' => [
                            'route'    => 'load[/:country]',
                            'defaults' => [
                                'action' => 'load'
                            ], 
                            'constraints' => [
                                'country' => '[a-zA-Z][a-zA-Z0-9_-]*'
                            ]
                        ]
                    ],
                     'add' => [
                        'type'    => 'Segment',
                        'options' => [
                            'route'    => 'add[/:host]',
                            'defaults' => [
                                'action' => 'add'
                            ]
                            , 
                            'constraints' => [
                                'host' => '[a-zA-Z][a-zA-Z0-9_-]*'
                            ]
                        ]
                    ] 
        ],
    ]
 ]
        ],
    
    'controllers' => [
        'factories'=>[
            'house\Controller\house' => 'house\factory\houseControllerFactory'
            
        ]  
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'layout/houselayout'  => __DIR__ . '/../view/layout/layout.phtml',
            'house/house/index'    => __DIR__ . '/../view/house/house.phtml',
            'house/templates/address'=> __DIR__ . "/../view/house/templates/address.phtml",
            'house/templates/information'=> __DIR__ . "/../view/house/templates/information.phtml",
            'house/templates/expenses'=> __DIR__ . "/../view/house/templates/expenses.phtml",
            'house/templates/detail'=> __DIR__ . "/../view/house/templates/detail.phtml",
            'house/templates/pictures'=> __DIR__ . "/../view/house/templates/pictures.phtml",
            'house/templates/personal'=> __DIR__ . "/../view/house/templates/personal.phtml"
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ],
    'service_manager' => [
        'factories'=>[
            'Zend\Db\Adapter\Adapter'=> 'Zend\Db\Adapter\AdapterServiceFactory',
            'house\service\houseService'=> 'house\factory\houseServiceFactory',
            'house\logic\addLogic'   => 'house\factory\logicFactory'
        ]
    ]
];