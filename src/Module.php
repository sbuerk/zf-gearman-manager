<?php

namespace ZfGearmanManager;

use GearmanClient;
use Zend\ModuleManager\Feature\ConfigProviderInterface;

class Module implements ConfigProviderInterface
{
    /**
     * Get module configuration.
     *
     * @return array
     */
    public function getConfig() {
        // for performance assume configfile exists.
        return include __DIR__ . '/../config/module.config.php';
    }
}
