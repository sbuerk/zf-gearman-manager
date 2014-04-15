**Note:** I don't consider this code production ready, so use at your own risk. The module only supports PECL Gearman, and if you use it, all your workers must be classes (whereas Gearman Manager on its own supports both worker classes and functions).

ZF Gearman Manager
==================

This is a Zend Framework 2 module that provides some basic integration between a ZF2 app and Brian Moon's Gearman Manager. Its main feature is to allow worker classes to be setup via. the ZF service locator, which allows app-related dependencies to be passed in.

## Installation

The module should be installed via. Composer. In addition to adding this module (`zf-gearman-manager`) and it's repository as a dependency, you need to add the repository for my forked version of Gearman Manager (which `zf-gearman-manager` requires). So your composer.json should look something like:

```json
{
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/tfountain/GearmanManager"
        },
        {
            "type": "vcs",
            "url": "git@github.com:tfountain/zf-gearman-manager"
        }
    ],
    "require": {
        "tfountain/zf-gearman-manager": "dev-master"
    }
}
```

The forked Gearman Manager is a fork of the main repo's "overhaul" branch, and contains some small changes to worker class instantiation and removal of error supression for worker activity.

## Usage

Instead of being discovered by scanning folders, with this module workers should be specified via. the app config (usually the `module.config.php`). This done using a `gearman_workers` array, where the config is the worker alias, and the value is the fully qualified name of the worker class:

```php
$config = array(
    'gearman_workers' => array(
        'do-stuff' => 'Application\Worker\DoStuff',
    ),
);
```

Since the workers are loaded by the service manager, you need to add an entry for each one to your service config, either as an invokable in `module.config.php`:

```php
$config = array(
    'service_manager' => array(
        'invokables' => array(
            'Application\Worker\DoStuff' => 'Application\Worker\DoStuff',
        ),
    ),
);
```

or as a factory in `Module.php`:

```php
namespace Application;

class Module
{
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'Application\Worker\DoStuff' => function ($sm) {
                    // setup and return worker class here
                },
            ),
        );
    }
}
```

## Worker class example

```php
namespace Application\Worker;

use ZfGearmanManager\Worker\WorkerInterface;

class DoStuff implements WorkerInterface
{
    public function run($job, &$log)
    {
        // get the string passed to the job
        $workload = $job->workload();

        // do stuff
    }
}
```

## Queueing jobs

For convenience the module defines a service config entry for the Gearman Client using the key 'GearmanClient' (still TODO: configuration to allow multiple servers?). So with this, to queue a job (from a controller):

```php
$gmClient = $this->getServiceLocator()->get('GearmanClient');
$gmClient->doBackground('do-stuff', $params); // where $params is the job workload (always a string)
```

Host and port for Gearman Client can be configured through the app config (usually the `module.config.php`).
This is done using a `gearman_client` array

```php
$config = array(
    'gearman_client' => array(
        'host' => 'gearmand.local',
        'port' => 31337,
    ),
);
```

## Running the daemon

The module includes an example `pecl_manager.php` which should be coped to a `bin` folder in your application root. This can then be run with the same command line options as the standard Gearman Manager script.

Since this version does not auto-discover worker classes from a folder, you'll also want to specify `-w /dev/null` or you'll get an error when Gearman Manager tries to check your worker dir on startup.

You may also want to create an ini configuration file (see Gearman Manager for examples). You can then run this with:

```
$ ./bin/pecl_manager.php -c config/gearman.ini -w /dev/null
```

as with Gearman Manager, adding `-v` increases verbosity of the output (`-vv` is more verbose, `-vvv` even more, and so on).
