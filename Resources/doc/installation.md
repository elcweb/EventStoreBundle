Getting Started With ElcwebEventStoreBundle
===========================================

## Prerequisites

This version of the bundle requires Symfony 2.3+.

## Installation

Installation is a quick process:

1. Download ElcwebEventStoreBundle using composer
2. Enable the Bundle
3. Configure the ElcwebEventStoreBundle
4. Import ElcwebEventStoreBundle routing
5. Update your database schema

### Step 1: Download ElcwebEventStoreBundle using composer

Add ElcwebEventStoreBundle in your composer.json:

```js
{
    "require": {
        "elcweb/eventstore-bundle": "dev-master"
    }
}
```

Now tell composer to download the bundle by running the command:

``` bash
$ php composer.phar update elcweb/eventstore-bundle
```

Composer will install the bundle to your project's `vendor/elcweb` directory.

### Step 2: Enable the bundle

Enable the bundle in the kernel:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Jmikola\WildcardEventDispatcherBundle\JmikolaWildcardEventDispatcherBundle(),
        new Elcweb\EventStoreBundle\ElcwebEventStoreBundle(),
    );
}
```

### Step 3: Configure the ElcwebEventStoreBundle

Add the following configuration to your `config.yml` file according to which type
of datastore you are using.

``` yaml
# app/config/config.yml
elcweb_eventstore:
    prefix: [] # add a list of you prefix exemple elcweb.# will get all event starting with elcweb.
```

### Step 4: Import ElcwebEventStoreBundle routing files

Now that you have activated and configured the bundle, all that is left to do is
import the ElcwebEventStoreBundle routing files.

By importing the routing files you will have ready made pages for listing event, etc.

In YAML:

``` yaml
# app/config/routing.yml
elcweb_eventstore:
    resource: "@ElcwebEventStoreBundle/Resources/config/routing.yml"
```

### Step 5: Update your database schema

Now that the bundle is configured, the last thing you need to do is update your
database schema because you have added a new entity, the `Event` class.

For ORM run the following command.

``` bash
$ php app/console doctrine:schema:update --force
```
