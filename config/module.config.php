<?php
return [
    'service_manager' => [
        'factories' => array(
            'GearmanClient'                                 => \ZfGearmanManager\GearmanClientFactory::class,
            \ZfGearmanManager\ZfGearmanPeclManager::class   => \ZfGearmanManager\ZfGearmanPeclManagerFactory::class,
        ),
        'aliases' => array(
            'ZfGearmanPeclManager' => \ZfGearmanManager\ZfGearmanPeclManager::class,
        ),
    ]
];