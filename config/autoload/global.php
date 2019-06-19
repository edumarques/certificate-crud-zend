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
        'driver' => 'Pdo',
        'adapters' => [
            'default_db' => [
                'driver' => 'Pdo',
                'dsn' => sprintf('sqlite:%s/data/financial-website.db', realpath(getcwd()))
            ]
        ]
    ],
    'service_manager' => [
        'factories' => [
            'Zend\Db\Adapter\Adapter' => 'Zend\Db\Adapter\AdapterServiceFactory'
        ],
        'abstract_factories' => [
            'Zend\Db\Adapter\AdapterAbstractServiceFactory'
        ]
    ]
];



