# Seller Ledger API for PHP

This is the official PHP client for the Seller Ledger API. The API documentation can be found [here](https://developers.sellerledger.com/#seller-ledger-api).

## Requirements

* PHP 8.0+
* [Guzzle](https://github.com/guzzle/guzzle) (installed via Composer)

## Installation

Use Composer to add `seller_ledger-php` as a dependency.

```
composer require seller_ledger-php
```

```
{
  "require": {
    "sellerledger/seller_ledger-php": "0.0.1"
  }
}
```

## Getting Started

```
require __DIR__ . '/vendor/autoload.php';
$client = SellerLedger\Client::withApiKey("your-api-key-here");
```
