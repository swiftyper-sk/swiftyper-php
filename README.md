# Swiftyper PHP

## Documentation

[`swiftyper-php` API documentation](https://developers.swiftyper.sk/docs/api/php) for PHP.

## Requirements

PHP 5.6.0+.

## Composer

You can install the bindings via [Composer](http://getcomposer.org/). Run the following command:

```bash
composer require swiftyper/swiftyper-php
```

To use the bindings, use Composer's [autoload](https://getcomposer.org/doc/01-basic-usage.md#autoloading):

```php
require_once('vendor/autoload.php');
```

## Manual installation

If you do not wish to use Composer, you can download the [latest release](https://github.com/swiftyper-sk/swiftyper-php/releases). Then, to use the bindings, include the `init.php` file.

```php
require_once('/path/to/swiftyper-php/init.php');
```

## Usage

Before you start using it, you need to set the API key which you can manage through your [user account](https://manage.swiftyper.sk/dashboard).

**API keys are unlimited by default.** Unlimited keys are not safe because they can be used by anyone and from anywhere. For production applications, we recommend setting API key restrictions as they help prevent unauthorized use and exhaustion of quotas. Restrictions determine which websites or IP addresses can use the API key.

```php
\Swiftyper\Swiftyper::setApiKey('API_KEY_OF_SWIFTYPER_BUSINESS');
$results = \Swiftyper\Business::query([
    'query'   => 'Google Slovakia',
    'country' => 'SK',
]);

var_dump($results->toArray());
```

### Accessing the Response of a Request

You can get the data from the API response on any object through the `getLastResponse()` method.

```php
$business = \Swiftyper\Business::detail('sk_WbilvhDEDokFTWk0FbNjeQ');
var_dump($business->getLastResponse());
```

### Configuring Automatic Retries

It is possible to configure the library to retry a certain number of times in case of a request failure.
This is useful when you want to make sure that a request is successfully processed even in case of a network failure.

```php
\Swiftyper\Swiftyper::setMaxNetworkRetries(2);
```
