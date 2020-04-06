# CrossbarHTTPPublisherBundle

[![Stable release][Last stable image]][Packagist link]
[![Unstable release][Last unstable image]][Packagist link]
[![Build status][Master build image]][Master build link]

[![Coverage Status][Master coverage image]][Master coverage link]
[![Scrutinizer][Master scrutinizer image]][Master scrutinizer link]
[![SL Insight][SL Insight image]][SL Insight link]

This bundle allows to submit PubSub events via HTTP/POST requests to a [Crossbar HTTP Publisher](http://crossbar.io/docs/HTTP-Bridge-Services-Publisher/), which is a simple, lightweight websocket server implemented in Python.

## Features

* Define multiple publishers
* Publishers are automatically registered into Syomfony's service container
* Send [signed requests](http://crossbar.io/docs/HTTP-Bridge-Services-Publisher/#signed-requests) easily
* Skip SSL certificate verification (useful in dev environment)

## Requirements
* PHP >=5.6
* Guzzle 5 or 6
* The following Symfony components (or the full-stack framework), version 2.7, 2.8, 3.x or 4.x:
    * symfony/framework-bundle
    * symfony/dependency-injection
    * symfony/config

## Installation

Require this package with Composer: 

```console
$ composer require facile-it/crossbar-http-publisher-bundle
```

... and register the bundle in your app (usually in `app/AppKernel.php`)

```php
public function registerBundles()
{
    return array(
        // ...
        new Facile\CrossbarHTTPPublisherBundle\FacileCrossbarHTTPPublisherBundle(),
    );
}
````

## Configuration
You just need to configure the publishers that you need to use; here is an example of the config, with the default values:

```yaml
facile_crossbar_http_publisher:
  connections:
    dummy_publisher_1:
      protocol: https                     #default: http
      host: crossbar.io                   #default: 127.0.0.1 
      port: 443                           #default: 8080
      path: publish                       #default: publish, often just empty
      auth_key: this_is_very_key          #default: null
      auth_secret: this_is_very_secret    #default: null
      ssl_ignore: true                    #default: false
  dummy_publisher_2:
      host: crossbar.tu
```

## Usage

Once you've done that, the publishers will be available as Symfony services in your container:

```php
$firstPublisher = $container->get('facile.crossbar.publisher.dummy_publisher_1');
$secondPublisher = $container->get('facile.crossbar.publisher.dummy_publisher_2');

$topic = 'com.myapp.topic1';

// using args
$firstPublisher->publish($topic, ['foo',1]);

// using kwargs
$secondPublisher->publish($topic, null, ['key'=>'value']);

// using both and printing Crossbar's response already decoded:
print_r($firstPublisher->publish($topic, ['foo',1], ['key'=>'value']));

// ouptuts:
//
// array(1) {
//   ["id"]=>
//   int(1395572605)
// }
```

[Last stable image]: https://poser.pugx.org/facile-it/crossbar-http-publisher-bundle/version.svg
[Last unstable image]: https://poser.pugx.org/facile-it/crossbar-http-publisher-bundle/v/unstable.svg
[Master build image]: https://travis-ci.org/facile-it/crossbar-http-publisher-bundle.svg
[Master scrutinizer image]: https://scrutinizer-ci.com/g/facile-it/crossbar-http-publisher-bundle/badges/quality-score.png?b=master
[Master coverage image]: https://codecov.io/gh/facile-it/crossbar-http-publisher-bundle/branch/master/graph/badge.svg
[SL Insight image]: https://insight.sensiolabs.com/projects/875c484f-104c-4664-b9f0-f2872492ae42/mini.png

[Packagist link]: https://packagist.org/packages/facile-it/crossbar-http-publisher-bundle
[Master build link]: https://travis-ci.org/facile-it/crossbar-http-publisher-bundle
[Appveyor build link]: https://ci.appveyor.com/project/Jean85/crossbar-http-publisher-bundle/branch/master
[Master climate link]: https://codeclimate.com/github/facile-it/crossbar-http-publisher-bundle
[Master scrutinizer link]: https://scrutinizer-ci.com/g/facile-it/crossbar-http-publisher-bundle/?branch=master
[Master coverage link]: https://codecov.io/gh/facile-it/crossbar-http-publisher-bundle
[SL Insight link]: https://insight.sensiolabs.com/projects/875c484f-104c-4664-b9f0-f2872492ae42
