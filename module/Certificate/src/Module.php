<?php
namespace Certificate;

use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\ResultSet;
use Zend\Authentication\Adapter\AdapterInterface;

class Module implements ConfigProviderInterface
{

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getServiceConfig()
    {
        return [
            'factories' => [
                Model\CertificateTable::class => function ($container) {
                    $tableGateway = $container->get('Model\CertificateTableGateway');
                    return new Model\CertificateTable($tableGateway);
                },
                'Model\CertificateTableGateway' => function ($container) {
                    $dbAdapter = $container->get('default_db');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Certificate());
                    return new TableGateway('certificate', $dbAdapter, null, $resultSetPrototype);
                }
            ]
        ];
    }

    public function getControllerConfig()
    {
        return [
            'factories' => [
                Controller\CertificateController::class => function ($container) {
                    return new Controller\CertificateController($container->get(Model\CertificateTable::class));
                }
            ]
        ];
    }
}

