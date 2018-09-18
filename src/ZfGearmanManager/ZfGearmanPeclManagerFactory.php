<?php

namespace ZfGearmanManager;


use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class ZfGearmanPeclManagerFactory
 *
 * @package ZfGearmanManager
 */
class ZfGearmanPeclManagerFactory implements FactoryInterface
{

    /**
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return ZfGearmanPeclManager
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new ZfGearmanPeclManager($serviceLocator);
    }

}