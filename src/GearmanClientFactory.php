<?php

namespace ZfGearmanManager;


use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use GearmanClient;

class GearmanClientFactory implements FactoryInterface
{
    
    public function __invoke(ContainerInterface $container, $requestedName, array $options = NULL)
    {
        $gmClient = new GearmanClient();
        $config = $container->get('config');
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