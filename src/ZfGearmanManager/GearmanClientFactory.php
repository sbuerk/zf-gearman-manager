<?php

namespace ZfGearmanManager;


use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use GearmanClient;

class GearmanClientFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $gmClient = new GearmanClient();
        $config = $serviceLocator->get('Config');
        if(isset($config['gearman_client'])){
            $conf = $config['gearman_client'];
        }
        $host = isset($conf['host']) ? $conf['host'] : '127.0.0.1';
        $port = isset($conf['port']) ? $conf['port'] : 4730;

        // add default server (localhost)
        $gmClient->addServer($host, $port);

        return $gmClient;
    }
}