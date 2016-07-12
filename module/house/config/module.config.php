<?php

namespace house;

return [
    
    'db'=>[
        'driver' => 'Pdo',
        'username'=>'root',
        'password'=>'',
        'dsn'    => 'mysql:dbname=house;host=localhost',
        'driver_options' => [
             \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
         ],  
    ],
    'router' => [
        'routes' => [
            'house' => [
                'type' => 'literal',
                'options' => [
                    'route'    => '/house',
                    'defaults' => [
                        '__NAMESPACE__' => 'house\Controller',
                        'controller' => 'Initial',
                        'action'     => 'index',
                    ]
                ],
                'may_terminate' => true,
                'child_routes' => [

                ], 
        ],
    ]
 ],
    
    'controllers' => [
        // array below routes the user to factory class which returns an instance of initial controller class
        'factories'=>[
            'house\Controller\Initial' => 'house\Factory\InitialControllerFactory'
        ]
        
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'house/initial/index'    => __DIR__ . '/../view/house/initial/initial.phtml'
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ]
    ],
    'service_manager' => [
        'factories'=>[
            'Zend\Db\Adapter\Adapter'           => 'Zend\Db\Adapter\AdapterServiceFactory',
        ]
    ]
];