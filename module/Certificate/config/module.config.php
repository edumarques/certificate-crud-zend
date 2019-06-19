<?php
namespace Certificate;

use Zend\Router\Http\Segment;
return [
    'router' => [
        'routes' => [
            'certificate' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/certificate[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+'
                    ],
                    'defaults' => [
                        'controller' => Controller\CertificateController::class,
                        'action' => 'index'
                    ]
                ]
            ]
        ]
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => [
            'layout/layout' => __DIR__ . '/../view/layout/layout.phtml'
        ],
        'template_path_stack' => [
            'certificate' => __DIR__ . '/../view'
        ]
    ]
];
