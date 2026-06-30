# Seller Ledger API for PHP

This is the official PHP client for the Seller Ledger API. The API documentation can be found [here](https://developers.sellerledger.com/#seller-ledger-api).

## Requirements

* PHP 8.0+
* [Guzzle](https://github.com/guzzle/guzzle) (installed via Composer)

## Installation

Use Composer to add `seller_ledger-php` as a dependency.

```
composer require sellerledger/seller_ledger-php
```

```json
{
  "require": {
    "sellerledger/seller_ledger-php": "^1.3"
  }
}
```

## Getting Started

```php
require __DIR__ . '/vendor/autoload.php';

$client = SellerLedger\Client::withApiKey("your-api-key-here");
```

All calls throw a `SellerLedger\Exception` (with the HTTP status as the exception code)
when the API responds with an error, so wrap calls in a `try/catch`.

## Connections

```php
$connection = $client->createConnection([
    "name" => "My Store",
    "balance_sheet_account_type" => "asset",
]);

$connectionId = $connection->id;
```

## Orders & refunds

```php
$client->createOrder($connectionId, [
    "transaction_id"       => "1001",
    "transaction_date"     => "2026-01-15",
    "currency_code"        => "USD",
    "total_amount"         => 110.00,
    "items_subtotal"       => 100.00,
    "shipping_amount"      => 10.00,
    "ship_to_country_code" => "US",
    "ship_to_state"        => "TX",
    "ship_to_zip"          => "78701",
    "items"                => [
        [
            "product_name" => "Widget",
            "quantity"     => 1,
            "total_amount" => 100.00,
            "item_amount"  => 100.00,
        ],
    ],
]);

$client->createRefund($connectionId, [
    "transaction_id"           => "1001-refund",
    "transaction_reference_id" => "1001",
    "transaction_date"         => "2026-01-20",
    "currency_code"            => "USD",
    "total_amount"             => 20.00,
    "items_subtotal"           => 20.00,
]);
```

## Sales tax calculation

Calculate the sales tax owed on an order. The request shape mirrors an order;
the response is the decoded `tax` object.

```php
$tax = $client->calculateSalesTax([
    "ship_to_country_code" => "US",
    "ship_to_state"        => "TX",
    "ship_to_zip"          => "78701",
    "items_subtotal"       => 100.00,
    "shipping_amount"      => 10.00,
    "items"                => [
        [
            "product_name" => "Widget",
            "quantity"     => 1,
            "total_amount" => 100.00,
            "item_amount"  => 100.00,
        ],
    ],
]);

if ($tax->has_nexus) {
    $rate   = $tax->rate;              // combined rate as a fraction, e.g. 0.0825
    $amount = $tax->amount_to_collect; // total tax to collect
}
```

A short timeout (or any other Guzzle request option) can be passed as the second
argument so a slow response never blocks a checkout:

```php
$tax = $client->calculateSalesTax($params, ["timeout" => 5, "connect_timeout" => 3]);
```

## Development

```
composer install
composer run tests
```
