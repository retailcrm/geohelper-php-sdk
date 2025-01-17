# Geohelper API PHP client

PHP-client for [Geohelper API](http://geohelper.info/ru/doc/api).

Use [API documentation](http://geohelper.info/ru/documentation)

## Requirements

* PHP 7.4 and higher

## Install

1) Get [composer](https://getcomposer.org/download/)

2) Run into your project directory:
```bash
composer require retailcrm/geohelper-php-sdk ~1.0.0
```

If you have not used `composer` before, include autoloader into your project.
```php
require 'path/to/vendor/autoload.php';
```

## Usage

### Get countries

```php

$clientInterface = new \GuzzleHttp\Client();

$client = new RetailCrm\Geohelper\ApiClient(
    $clientInterface,
    'api_key'
);

$response = $client->countriesList();

if ($response->isSuccessful()) {
    $countries = isset($response['result']) ? $response['result'] : array();
    foreach ($countries as $country) {
        echo $country['name'];
    }
} else {
    echo sprintf(
        "Error: [HTTP-code %s] %s",
        $response->getStatusCode(),
        $response->getErrorMsg()
    );
}
```
