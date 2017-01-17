# CrossbarHTTPPublisherBundle

[![Stable release][Last stable image]][Packagist link]
[![Unstable release][Last unstable image]][Packagist link]
[![Build status][Master build image]][Master build link]

[![Coverage Status][Master coverage image]][Master coverage link]
[![Scrutinizer][Master scrutinizer image]][Master scrutinizer link]
[![SL Insight][SL Insight image]][SL Insight link]

This bundle allows to submit PubSub events via HTTP/POST requests to a [Crossbar HTTP Publisher](http://crossbar.io/docs/HTTP-Bridge-Services-Publisher/).

####Supports:

* Multiple publisher, automatically registered into Service Container
* [Signed requests](http://crossbar.io/docs/HTTP-Bridge-Services-Publisher/#signed-requests)
* SSL certificate verification skip (useful in dev enviroment)

####Requires:

* php: >=5.4
* symfony/http-kernel: >=2.3
* symfony/framework-bundle: >=2.3
* symfony/dependency-injection: >=2.3
* symfony/config: >=2.3
* symfony/yaml: >=2.3
* guzzlehttp/guzzle": >=5.0,<6.0

####Installation

As simple as download it 

```console
$ composer require facile-it/crossbar-http-publisher-bundle dev-master
```

and register the bundle in your app (usually in app/AppKernel.php)
````php
public function registerBundles()
{
    return array(
        // ...
        new Facile\CrossbarHTTPPublisherBundle\FacileCrossbarHTTPPublisherBundle(),
    );
}
````
####Configuration

Quite easy, just add something like this in your config.yml:

````yaml
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
````

and you'll can get the publisher services from the container:

````php
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

````

[Last stable image]: https://poser.pugx.org/facile-it/crossbar-http-publisher-bundle/version.svg
[Last unstable image]: https://poser.pugx.org/facile-it/crossbar-http-publisher-bundle/v/unstable.svg
[Master build image]: https://travis-ci.org/facile-it/crossbar-http-publisher-bundle.svg
[Master scrutinizer image]: https://scrutinizer-ci.com/g/facile-it/crossbar-http-publisher-bundle/badges/quality-score.png?b=master
[Master coverage image]: https://coveralls.io/repos/facile-it/crossbar-http-publisher-bundle/badge.svg?branch=master&service=github
[SL Insight image]: https://insight.sensiolabs.com/projects/875c484f-104c-4664-b9f0-f2872492ae42/mini.png

[Packagist link]: https://packagist.org/packages/facile-it/crossbar-http-publisher-bundle
[Master build link]: https://travis-ci.org/facile-it/crossbar-http-publisher-bundle
[Appveyor build link]: https://ci.appveyor.com/project/Jean85/crossbar-http-publisher-bundle/branch/master
[Master climate link]: https://codeclimate.com/github/facile-it/crossbar-http-publisher-bundle
[Master scrutinizer link]: https://scrutinizer-ci.com/g/facile-it/crossbar-http-publisher-bundle/?branch=master
[Master coverage link]: https://coveralls.io/github/facile-it/crossbar-http-publisher-bundle?branch=master
[SL Insight link]: https://insight.sensiolabs.com/projects/875c484f-104c-4664-b9f0-f2872492ae42
