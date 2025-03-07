# Amazon Product Advertising API 5.0 PHP Client

A lightweight PHP package for interacting with Amazon's Product Advertising API 5.0. This package provides a simple and reliable way to fetch product data from Amazon's catalog using the Product Advertising API.

## Features

- Simple, straightforward API for getting Amazon product information
- Handles AWS v4 request signing
- Supports all Amazon marketplaces
- Fully unit tested
- No dependency on Amazon's SDK

## Requirements

- PHP 7.4 or higher
- Guzzle HTTP client

## Installation

You can install the package via composer:

```bash
composer require custom/amazon-advertising-api
```

## Usage

### Basic Usage

```php
<?php

use Custom\AmazonAdvertisingApi\AmazonAdvertisingApi;
use Custom\AmazonAdvertisingApi\Enums\Region;
use Custom\AmazonAdvertisingApi\Enums\Resource;

// Initialize the client with your Amazon PA-API credentials
$client = new AmazonAdvertisingApi(
    'YOUR_ACCESS_KEY',
    'YOUR_SECRET_KEY',
    'YOUR_PARTNER_TAG',
    Region::UNITED_STATES // Optional, defaults to US
);

// Get a single product by ASIN
try {
    $product = $client->getItem('B07PDHSJ1H', [
        Resource::ITEM_INFO_TITLE,
        Resource::IMAGES_PRIMARY,
        Resource::OFFERS_LISTINGS
    ]);
    
    if ($product) {
        echo "Product Title: " . $product['ItemInfo']['Title']['DisplayValue'] . "\n";
        echo "Product URL: " . $product['DetailPageURL'] . "\n";
    } else {
        echo "Product not found.\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

// Get multiple products by ASINs
try {
    $response = $client->getItems(['B07PDHSJ1H', 'B07G4MNFS1'], [
        Resource::ITEM_INFO_TITLE,
        Resource::IMAGES_PRIMARY
    ]);
    
    foreach ($response['ItemsResult']['Items'] as $product) {
        echo "Product Title: " . $product['ItemInfo']['Title']['DisplayValue'] . "\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
```

### Available Resources

The package provides constants for all available resources in the `Resource` enum:

```php
use Custom\AmazonAdvertisingApi\Enums\Resource;

// Use specific resources
$resources = [
    Resource::ITEM_INFO_TITLE,
    Resource::ITEM_INFO_FEATURES,
    Resource::ITEM_INFO_PRODUCT_INFO,
    Resource::IMAGES_PRIMARY,
    Resource::OFFERS_LISTINGS
];

// Or get all available resources
$all_resources = Resource::getAllResources();
```

### Regional Support

The package supports all Amazon marketplaces through the `Region` enum:

```php
use Custom\AmazonAdvertisingApi\Enums\Region;

// UK marketplace
$client = new AmazonAdvertisingApi(
    'YOUR_ACCESS_KEY',
    'YOUR_SECRET_KEY',
    'YOUR_PARTNER_TAG',
    Region::UNITED_KINGDOM
);

// Germany marketplace
$client = new AmazonAdvertisingApi(
    'YOUR_ACCESS_KEY',
    'YOUR_SECRET_KEY',
    'YOUR_PARTNER_TAG',
    Region::GERMANY
);
```

## Available Regions

- `Region::AUSTRALIA` - Amazon Australia
- `Region::BRAZIL` - Amazon Brazil
- `Region::CANADA` - Amazon Canada
- `Region::FRANCE` - Amazon France
- `Region::GERMANY` - Amazon Germany
- `Region::INDIA` - Amazon India
- `Region::ITALY` - Amazon Italy
- `Region::JAPAN` - Amazon Japan
- `Region::MEXICO` - Amazon Mexico
- `Region::NETHERLANDS` - Amazon Netherlands
- `Region::SINGAPORE` - Amazon Singapore
- `Region::SAUDI_ARABIA` - Amazon Saudi Arabia
- `Region::SPAIN` - Amazon Spain
- `Region::SWEDEN` - Amazon Sweden
- `Region::TURKEY` - Amazon Turkey
- `Region::UNITED_ARAB_EMIRATES` - Amazon UAE
- `Region::UNITED_KINGDOM` - Amazon UK
- `Region::UNITED_STATES` - Amazon US

## Background

### Why this package?

I developed this package because Amazon's own SDK was returning 500 Bad Response errors when attempting to interact with the Amazon Product Advertising API. This made the SDK unusable for our needs.

### Our solution

This package resolves these issues by manually implementing a simple version of the Amazon Product Advertising API request using Guzzle.

## Testing

The package includes a comprehensive test suite. You can run the tests with the following command:

```bash
composer test
```

## Extending

If you need to support additional operations beyond `GetItems`, you can extend the `AmazonAdvertisingApi` class:

```php
use Custom\AmazonAdvertisingApi\AmazonAdvertisingApi;

class ExtendedAmazonApi extends AmazonAdvertisingApi
{
    private const SEARCH_ITEMS_URI_PATH = '/paapi5/searchitems';
    private const SEARCH_ITEMS_TARGET = 'com.amazon.paapi5.v1.ProductAdvertisingAPIv1.SearchItems';
    
    public function searchItems(string $keywords, array $resources = []): array
    {
        // Implementation here...
    }
}
```

## License

This package is open-sourced software licensed under the MIT license. 