# Swiftyper PHP

## Dokumentácia

[`swiftyper-node` API dokumentácia](https://developers.swiftyper.sk/docs/api/php) pre PHP.

## Požiadavky

PHP 5.6.0+.

## Composer

Knižnicu je možné nainštalovať cez [Composer](http://getcomposer.org/). Stačí zadať príkaz:

```bash
composer require swiftyper/swiftyper-php
```

Následne do vašej aplikácie pridajte [autoload](https://getcomposer.org/doc/01-basic-usage.md#autoloading):

```php
require_once('vendor/autoload.php');
```

## Manuálna inštalácia

Pri manuálnej inštalácii stačí stiahnuť [vydanie knižnice](https://github.com/swiftyper-sk/swiftyper-php/releases).
Následne je nutné pridať tento inicializačný súbor:

```php
require_once('/path/to/swiftyper-php/init.php');
```

## Použitie

Pred začatím používania je nutné nastaviť API kľúč ktorý môžete spravovať cez Váš [používateľský účet](https://manage.swiftyper.sk/dashboard).

**API kľúče sú predvolene neobmedzené.** Neobmedzené kľúče nie sú bezpečné, pretože ich môže používať ktokoľvek a odkiaľkoľvek. Pre produkčné aplikácie odporúčame nastaviť obmedzenia API kľúča nakoľko pomáhajú zabrániť neoprávnenému použitiu a vyčerpávaniu kvót. Obmedzenia určujú, ktoré webové stránky alebo IP adresy môžu používať API kľúč.

```php
$swiftyper = \Swiftyper\Swiftyper::setApiKey('VÁŠ_API_KĽÚČ_SLUŽBY_BUSINESS');
$business = $swiftyper->business->query([
    'query'   => 'Google Slovakia',
    'country' => 'SK',
]);

var_dump($business);
```

### Pristupovanie k odpovedi požiadavky

Údaje z API odpovede na ľubovoľnom objekte môžete získať prostredníctvom metódy `getLastResponse()`.

```php
$business = $swiftyper->customers->detail('sk_WbilvhDEDokFTWk0FbNjeQ');
var_dump($business->getLastResponse());
```

### Konfigurácia automatického znovupripojenia

Knižnici je možné nakonfigurovať počet opakovaní v prípade zlyhania požiadavky.

```php
\Swiftyper\Swiftyper::setMaxNetworkRetries(2);
```
