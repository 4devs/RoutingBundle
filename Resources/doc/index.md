Getting Started With RoutingBundle
===========================================

## Installation and usage

Installation and usage is a quick:

1. Download RoutingBundle using composer
2. Enable the Bundle
3. Use the bundle


### Step 1: Download RoutingBundle using composer

Add RoutingBundle in your composer.json:

```js
{
    "require": {
        "fdevs/routing-bundle": "*"
    }
}
```

Now tell composer to download the bundle by running the command:

``` bash
$ php composer.phar update fdevs/routing-bundle
```

Composer will install the bundle to your project's `vendor/fdevs` directory.


### Step 2: Enable the bundle

Enable the bundle in the kernel:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new FDevs\RoutingBundle\FDevsRoutingBundle(),
    );
}
```


### Step 3: Use the bundle
