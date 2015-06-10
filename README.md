# CrossbarHTTPPublisherBundle

This bundle allows to submit PubSub events via HTTP/POST requests to a [Crossbar HTTP Publisher](http://crossbar.io/docs/HTTP-Bridge-Services-Publisher/).

####Supports:

* Multiple publisher, automatically registered into Service Container
* [Signed requests](http://crossbar.io/docs/HTTP-Bridge-Services-Publisher/#signed-requests)
* SSL certificate verification skip (useful in dev enviroment)

####Requires:

* php: >=5.3
* symfony/http-kernel: >=2.3
* symfony/framework-bundle: >=2.3
* symfony/dependency-injection: >=2.3
* symfony/config: >=2.3
* symfony/yaml: >=2.3
* guzzlehttp/guzzle": >=5.0,<6.0

####Installation

As simple as 

```
composer require facile-it/CrossbarHTTPPublisherBundle dev-master
```

####Configuration:

Quite easy, just add something like this in your config.yml:

````
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

````
$firstPublisher = $container->get('facile.crossbar.publisher.dummy_publisher_1');
$secondPublisher = $container->get('facile.crossbar.publisher.dummy_publisher_2');

$topic = 'com.myapp.topic1';

// using args
$firstPublisher->publish($topic, ['foo',1]);

// using kwargs
$secondPublisher->publish($topic, null, ['key'=>'value']);

// using both and printing Crossbar's response already decoded:
print_r($firstPublisher->publish($topic, ['foo',1], ['key'=>'value']););

// ouptuts:
//
// array(1) {
//   ["id"]=>
//   int(1395572605)
// }

````