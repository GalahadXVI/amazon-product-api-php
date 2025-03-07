<?php

require_once __DIR__ . '/../vendor/autoload.php';

use GalahadXVI\AmazonProductApi\AmazonProductApi;
use GalahadXVI\AmazonProductApi\Enums\Region;
use GalahadXVI\AmazonProductApi\Enums\Resource;
use GalahadXVI\AmazonProductApi\Exception\AmazonAdvertisingApiException;

// Replace with your own credentials
$access_key = 'YOUR_ACCESS_KEY';
$secret_key = 'YOUR_SECRET_KEY';
$partner_tag = 'YOUR_PARTNER_TAG'; // Your Amazon Associate tag
$country_code = Region::UNITED_STATES; // or any other supported region

// Initialize the client
$client = new AmazonProductApi(
    $access_key,
    $secret_key,
    $partner_tag,
    $country_code
);

// Define resources to request
$resources = [
    Resource::ITEM_INFO_TITLE,
    Resource::ITEM_INFO_FEATURES,
    Resource::ITEM_INFO_BY_LINE_INFO,
    Resource::IMAGES_PRIMARY,
    Resource::OFFERS_LISTINGS
];

// Get a single product by ASIN
try {
    echo "Fetching product details...\n";
    
    $product = $client->getItem('B07PDHSJ1H', $resources);
    
    if ($product) {
        echo "\nProduct found!\n";
        echo "Title: " . $product['ItemInfo']['Title']['DisplayValue'] . "\n";
        
        if (isset($product['ItemInfo']['Features']['DisplayValues'])) {
            echo "\nFeatures:\n";
            foreach ($product['ItemInfo']['Features']['DisplayValues'] as $feature) {
                echo "- " . $feature . "\n";
            }
        }
        
        if (isset($product['DetailPageURL'])) {
            echo "\nProduct URL: " . $product['DetailPageURL'] . "\n";
        }
    } else {
        echo "Product not found.\n";
    }
} catch (AmazonAdvertisingApiException $e) {
    echo "API Error: " . $e->getMessage() . "\n";
} catch (Exception $e) {
    echo "General Error: " . $e->getMessage() . "\n";
}

// Get multiple products by ASINs
try {
    echo "\n\nFetching multiple products...\n";
    
    $response = $client->getItems(['B07PDHSJ1H', 'B07G4MNFS1'], [Resource::ITEM_INFO_TITLE]);
    
    if (isset($response['ItemsResult']['Items']) && !empty($response['ItemsResult']['Items'])) {
        echo "\nProducts found: " . count($response['ItemsResult']['Items']) . "\n";
        
        foreach ($response['ItemsResult']['Items'] as $product) {
            echo "- " . $product['ASIN'] . ": " 
                . $product['ItemInfo']['Title']['DisplayValue'] . "\n";
        }
    } else {
        echo "No products found.\n";
    }
} catch (AmazonAdvertisingApiException $e) {
    echo "API Error: " . $e->getMessage() . "\n";
} catch (Exception $e) {
    echo "General Error: " . $e->getMessage() . "\n";
} 