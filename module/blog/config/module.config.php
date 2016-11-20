<?php

namespace blog;

return [
    
    'db'=>[
        'driver' => 'Pdo',
        'username'=>'root',
        'password'=>'',
        'dsn'    => 'mysql:dbname=blog;host=localhost',
        'driver_options' => [
             \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
         ],  
    ],
      'controllers' => [
        // array below routes the user to factory class which returns an instance of initial controller class
        'factories'=>[
            'blog\Controller\Initial' => 'blog\factory\InitialControllerFactory'
        ]
        
    ],
    'router' => [
        'routes' => [
            'blog' => [
                'type' => 'Segment',
                'options' => [
                    'route'    => '/blog[/:id]',
                    'defaults' => [
                        '__NAMESPACE__' => 'blog\Controller',
                        'controller' => 'Initial',
                        'action'     => 'index',
                    ],
                    'constraints' => [
                                'id' => '[0-9]\d*'
                     ]
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'show' => [
                        'type'    => 'Segment',
                        'options' => [
                            'route'    => '/show[/:id]',
                            'defaults' => [
                                'action' => 'show'
                            ], 
                            'constraints' => [
                                'id' => '[0-9]\d*'
                            ]
                        ],
                    ],
                     'populate' => [
                        'type'    => 'Segment',
                        'options' => [
                            'route'    => '/populate[/:author]',
                            'defaults' => [
                                'action' => 'populate'
                            ], 
                            'constraints' => [
                                'author' => '[a-zA-Z][a-zA-Z0-9_-]*'
                            ]
                        ],
                    ],
                    'writer' => [
                        'type'    => 'Segment',
                        'options' => [
                            'route'    => '/writer[/:author]',
                            'defaults' => [
                                'action' => 'writer'
                            ], 
                            'constraints' => [
                                'author' => '[a-zA-Z][a-zA-Z0-9_-]*'
                            ]
                        ],
                    ],
                    'add' => [
                        'type'    => 'Segment',
                        'options' => [
                            'route'    => '/add[/:author]',
                            'defaults' => [
                                'action' => 'add'
                            ], 
                            'constraints' => [
                                'author' => '[a-zA-Z][a-zA-Z0-9_-]*'
                            ]
                        ],
                    ]

                ], 
        ],
    ]
 ],
    
  
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'blog/initial/index'    => __DIR__ . '/../view/blog/initial/initial.phtml',
            'blog/initial/show'     => __DIR__ . '/../view/blog/initial/show.phtml',
            'blog/initial/populate' => __DIR__ . '/../view/blog/initial/populate.phtml',
            'blog/initial/writer'   => __DIR__ .'/../view/blog/initial/writer.phtml'
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ]
    ],
    'service_manager' => [
        'factories'=>[
            'blog\Mapper\DataMapperInterface'   => 'blog\Factory\PostMapperFactory',
            'blog\Service\PostServiceInterface' => 'blog\Factory\PostServiceFactory',
            'Zend\Db\Adapter\Adapter'           => 'Zend\Db\Adapter\AdapterServiceFactory',
        ]
    ]
];