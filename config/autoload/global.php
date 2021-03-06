<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

return [
     'db' => [
         'driver'         => 'Pdo',
         'dsn'            => 'mysql:dbname=nepalonboard;host=localhost',
         'driver_options' => [
             PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
         ],
         'adapters'=> [
             'db1'=>[
                'driver' => 'Pdo',
                'dsn'    => 'mysql:dbname=nepalonboard;host=localhost',
                'driver_options' => [
                    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
                ],
              ],
             'db2'=>[
                'driver' => 'Pdo',
                'dsn'    => 'mysql:dbname=blog;host=localhost',
                'driver_options' => [
                    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
                ]
              ],
               'db3'=>[
                'driver' => 'Pdo',
                'dsn'    => 'mysql:dbname=house;host=localhost',
                'driver_options' => [
                    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
                ]
              ]
         ]
      ],   
     'service_manager' => [
         'abstract_factories' => [
            'Zend\Db\Adapter\AdapterAbstractServiceFactory'
         ],
         'factories' => [
             'Zend\Db\Adapter\Adapter'
                     => 'Zend\Db\Adapter\AdapterServiceFactory',
         ],
     ],
 ];