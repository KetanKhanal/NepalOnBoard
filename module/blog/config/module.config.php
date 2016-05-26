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
    'router' => [
        'routes' => [
            'blog' => [
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => [
                    'route'    => '/blog',
                    'defaults' => [
                        'controller' => 'blog\Controller\Initial',
                        'action'     => 'index',
                    ],
                ],
            ],
            
            
        ],
    ],
    'controllers' => [
        // array below routes the user to factory class which returns an instance of initial controller class
        'factories'=>[
            'blog\Controller\Initial' => 'blog\Factory\InitialControllerFactory'
        ]
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'blog/initial/index' => __DIR__ . '/../view/blog/initial/initial.phtml'
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