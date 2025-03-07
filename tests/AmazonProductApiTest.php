<?php

namespace GalahadXVI\AmazonProductApi\Tests;

use GalahadXVI\AmazonProductApi\AmazonProductApi;
use GalahadXVI\AmazonProductApi\Enums\Region;
use GalahadXVI\AmazonProductApi\Enums\Resource;
use GalahadXVI\AmazonProductApi\Exception\AmazonAdvertisingApiException;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Mockery;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

/**
 * Class AmazonAdvertisingApiTest
 * 
 * Tests for the AmazonAdvertisingApi class
 * 
 * @package Custom\AmazonAdvertisingApi\Tests
 */
class AmazonProductApiTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
    
    /**
     * Test constructor sets properties correctly
     */
    public function testConstructorSetsPropertiesCorrectly()
    {
        $api = new AmazonProductApi(
            'test-access-key',
            'test-secret-key',
            'test-partner-tag',
            Region::UNITED_KINGDOM
        );
        
        $reflection = new ReflectionClass($api);
        
        $access_key_prop = $reflection->getProperty('access_key');
        $access_key_prop->setAccessible(true);
        $this->assertEquals('test-access-key', $access_key_prop->getValue($api));
        
        $secret_key_prop = $reflection->getProperty('secret_key');
        $secret_key_prop->setAccessible(true);
        $this->assertEquals('test-secret-key', $secret_key_prop->getValue($api));
        
        $partner_tag_prop = $reflection->getProperty('partner_tag');
        $partner_tag_prop->setAccessible(true);
        $this->assertEquals('test-partner-tag', $partner_tag_prop->getValue($api));
        
        $country_code_prop = $reflection->getProperty('country_code');
        $country_code_prop->setAccessible(true);
        $this->assertEquals(Region::UNITED_KINGDOM, $country_code_prop->getValue($api));
    }
    
    /**
     * Test getItems method with mocked HTTP client
     */
    public function testGetItemsWithMockedResponse()
    {
        // Create a mock response
        $mock_response = [
            'ItemsResult' => [
                'Items' => [
                    [
                        'ASIN' => 'B07PDHSJ1H',
                        'DetailPageURL' => 'https://www.amazon.co.uk/dp/B07PDHSJ1H',
                        'ItemInfo' => [
                            'Title' => [
                                'DisplayValue' => 'Test Product Title'
                            ]
                        ]
                    ]
                ]
            ]
        ];
        
        // Create a mock handler
        $mock = new MockHandler([
            new Response(200, [], json_encode($mock_response))
        ]);
        
        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);
        
        // Create the API instance with a mocked HTTP client
        $api = new AmazonProductApi(
            'test-access-key',
            'test-secret-key',
            'test-partner-tag'
        );
        
        $reflection = new ReflectionClass($api);
        $http_client_prop = $reflection->getProperty('http_client');
        $http_client_prop->setAccessible(true);
        $http_client_prop->setValue($api, $client);
        
        // Call the getItems method
        $result = $api->getItems(['B07PDHSJ1H'], [Resource::ITEM_INFO_TITLE]);
        
        // Assert the result
        $this->assertEquals($mock_response, $result);
    }
    
    /**
     * Test getItem method with mocked response
     */
    public function testGetItemWithMockedResponse()
    {
        // Create a mock response
        $mock_response = [
            'ItemsResult' => [
                'Items' => [
                    [
                        'ASIN' => 'B07PDHSJ1H',
                        'DetailPageURL' => 'https://www.amazon.co.uk/dp/B07PDHSJ1H',
                        'ItemInfo' => [
                            'Title' => [
                                'DisplayValue' => 'Test Product Title'
                            ]
                        ]
                    ]
                ]
            ]
        ];
        
        // Create a mock handler
        $mock = new MockHandler([
            new Response(200, [], json_encode($mock_response))
        ]);
        
        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);
        
        // Create the API instance with a mocked HTTP client
        $api = new AmazonProductApi(
            'test-access-key',
            'test-secret-key',
            'test-partner-tag'
        );
        
        $reflection = new ReflectionClass($api);
        $http_client_prop = $reflection->getProperty('http_client');
        $http_client_prop->setAccessible(true);
        $http_client_prop->setValue($api, $client);
        
        // Call the getItem method
        $result = $api->getItem('B07PDHSJ1H', [Resource::ITEM_INFO_TITLE]);
        
        // Assert the result
        $this->assertEquals($mock_response['ItemsResult']['Items'][0], $result);
    }
    
    /**
     * Test getItem returns null when no item is found
     */
    public function testGetItemReturnsNullWhenNoItemFound()
    {
        // Create a mock response with no items
        $mock_response = [
            'ItemsResult' => [
                'Items' => []
            ]
        ];
        
        // Create a mock handler
        $mock = new MockHandler([
            new Response(200, [], json_encode($mock_response))
        ]);
        
        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);
        
        // Create the API instance with a mocked HTTP client
        $api = new AmazonProductApi(
            'test-access-key',
            'test-secret-key',
            'test-partner-tag'
        );
        
        $reflection = new ReflectionClass($api);
        $http_client_prop = $reflection->getProperty('http_client');
        $http_client_prop->setAccessible(true);
        $http_client_prop->setValue($api, $client);
        
        // Call the getItem method
        $result = $api->getItem('B07PDHSJ1H');
        
        // Assert the result is null
        $this->assertNull($result);
    }
} 