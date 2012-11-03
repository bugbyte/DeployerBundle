Wraps [bugbyte/deployer](https://github.com/bugbyte/deployer) in a symfony 2.1.x bundle.

INSTALLATION

The easiest way is to use Composer:

    {
        "require": {
            "bugbyte/deployer-bundle": "1.0.*"
        }
    }

USAGE

Enable the bundle in the AppKernel

``` php
    $bundles = array(
        ...
        new Bugbyte\DeployerBundle\BugbyteDeployerBundle(),
    );
```

copy the config.yml from the bundle into your project's config.yml and configure it to suit your needs.

Then, you can deploy your project:

    php app/console bb:deploy deploy prod

For some inline help, use:

    php app/console bb:deploy
