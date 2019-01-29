<?php

namespace ZfGearmanManager;


use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;


/**
 * Class ZfGearmanPeclManagerFactory
 *
 * @package ZfGearmanManager
 */
class ZfGearmanPeclManagerFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = NULL)
    {
        return new ZfGearmanPeclManager($container);
    }
    

}