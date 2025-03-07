<?php

namespace GalahadXVI\AmazonProductApi\Tests;

use GalahadXVI\AmazonProductApi\AmazonProductApi;
use GalahadXVI\AmazonProductApi\Enums\Region;
use GalahadXVI\AmazonProductApi\Enums\GetItems\Resource;
use GalahadXVI\AmazonProductApi\Exception\AmazonAdvertisingApiException;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Psr7\Request;
use Mockery;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

/**
 * Class GetItemsTest
 * 
 * Tests for the GetItems functionality of the Amazon Product API
 * 
 * @package GalahadXVI\AmazonProductApi\Tests
 */
class GetItemsTest extends TestCase
{
    private $default_mock_response = [
        'ItemsResult' => [
            'Items' => [
                [
                    'ASIN' => 'B07PDHSJ1H',
                    'DetailPageURL' => 'https://www.amazon.co.uk/dp/B07PDHSJ1H',
                    'ItemInfo' => [
                        'Title' => [
                            'DisplayValue' => 'Test Product Title'
                        ],
                        'Features' => [
                            'DisplayValues' => ['Feature 1', 'Feature 2']
                        ],
                        'ProductInfo' => [
                            'Price' => [
                                'Amount' => 99.99,
                                'Currency' => 'USD'
                            ]
                        ]
                    ],
                    'Images' => [
                        'Primary' => [
                            'Large' => [
                                'URL' => 'https://example.com/image.jpg'
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ];

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
    
    /**
     * Test constructor with invalid parameters
     */
    public function testConstructorWithInvalidParameters()
    {
        $this->expectException(\InvalidArgumentException::class);
        new AmazonProductApi('', '', '');
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
     * Test constructor with invalid region
     */
    public function testConstructorWithInvalidRegion()
    {
        $this->expectException(\InvalidArgumentException::class);
        new AmazonProductApi(
            'test-access-key',
            'test-secret-key',
            'test-partner-tag',
            'INVALID_REGION'
        );
    }
    
    /**
     * Test getItems with empty ASINs array
     */
    public function testGetItemsWithEmptyAsins()
    {
        $api = new AmazonProductApi(
            'test-access-key',
            'test-secret-key',
            'test-partner-tag'
        );
        
        $this->expectException(\InvalidArgumentException::class);
        $api->getItems([]);
    }

    /**
     * Test getItems with too many ASINs
     */
    public function testGetItemsWithTooManyAsins()
    {
        $api = new AmazonProductApi(
            'test-access-key',
            'test-secret-key',
            'test-partner-tag'
        );
        
        $this->expectException(\InvalidArgumentException::class);
        $api->getItems(array_fill(0, 11, 'B07PDHSJ1H'));
    }

    /**
     * Test getItems with invalid ASIN format
     */
    public function testGetItemsWithInvalidAsinFormat()
    {
        $api = new AmazonProductApi(
            'test-access-key',
            'test-secret-key',
            'test-partner-tag'
        );
        
        $this->expectException(\InvalidArgumentException::class);
        $api->getItems(['invalid-asin-format']);
    }
    
    /**
     * Test getItems method with mocked HTTP client
     */
    public function testGetItemsWithMockedResponse()
    {
        $mock = new MockHandler([
            new Response(200, [], json_encode($this->default_mock_response))
        ]);
        
        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);
        
        $api = new AmazonProductApi(
            'test-access-key',
            'test-secret-key',
            'test-partner-tag'
        );
        
        $reflection = new ReflectionClass($api);
        $http_client_prop = $reflection->getProperty('http_client');
        $http_client_prop->setAccessible(true);
        $http_client_prop->setValue($api, $client);
        
        $result = $api->getItems(['B07PDHSJ1H'], [Resource::ITEM_INFOTITLE]);
        
        $this->assertEquals($this->default_mock_response, $result);
    }

    /**
     * Test getItems with client exception
     */
    public function testGetItemsWithClientException()
    {
        $mock = new MockHandler([
            new ClientException(
                'Bad Request',
                new Request('POST', 'test'),
                new Response(400, [], json_encode(['errors' => ['Invalid parameter']]))
            )
        ]);
        
        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);
        
        $api = new AmazonProductApi(
            'test-access-key',
            'test-secret-key',
            'test-partner-tag'
        );
        
        $reflection = new ReflectionClass($api);
        $http_client_prop = $reflection->getProperty('http_client');
        $http_client_prop->setAccessible(true);
        $http_client_prop->setValue($api, $client);
        
        $this->expectException(AmazonAdvertisingApiException::class);
        $api->getItems(['B07PDHSJ1H']);
    }

    /**
     * Test getItems with server exception
     */
    public function testGetItemsWithServerException()
    {
        $mock = new MockHandler([
            new ServerException(
                'Internal Server Error',
                new Request('POST', 'test'),
                new Response(500)
            )
        ]);
        
        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);
        
        $api = new AmazonProductApi(
            'test-access-key',
            'test-secret-key',
            'test-partner-tag'
        );
        
        $reflection = new ReflectionClass($api);
        $http_client_prop = $reflection->getProperty('http_client');
        $http_client_prop->setAccessible(true);
        $http_client_prop->setValue($api, $client);
        
        $this->expectException(AmazonAdvertisingApiException::class);
        $api->getItems(['B07PDHSJ1H']);
    }

    /**
     * Test getItems with all available resources
     */
    public function testGetItemsWithAllResources()
    {
        $mock = new MockHandler([
            new Response(200, [], json_encode($this->default_mock_response))
        ]);
        
        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);
        
        $api = new AmazonProductApi(
            'test-access-key',
            'test-secret-key',
            'test-partner-tag'
        );
        
        $reflection = new ReflectionClass($api);
        $http_client_prop = $reflection->getProperty('http_client');
        $http_client_prop->setAccessible(true);
        $http_client_prop->setValue($api, $client);
        
        $result = $api->getItems(['B07PDHSJ1H'], Resource::getAllowableEnumValues());
        
        $this->assertEquals($this->default_mock_response, $result);
    }
    
    /**
     * Test getItem method with mocked response
     */
    public function testGetItemWithMockedResponse()
    {
        $mock = new MockHandler([
            new Response(200, [], json_encode($this->default_mock_response))
        ]);
        
        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);
        
        $api = new AmazonProductApi(
            'test-access-key',
            'test-secret-key',
            'test-partner-tag'
        );
        
        $reflection = new ReflectionClass($api);
        $http_client_prop = $reflection->getProperty('http_client');
        $http_client_prop->setAccessible(true);
        $http_client_prop->setValue($api, $client);
        
        $result = $api->getItem('B07PDHSJ1H', [Resource::ITEM_INFOTITLE]);
        
        $this->assertEquals($this->default_mock_response['ItemsResult']['Items'][0], $result);
    }
    
    /**
     * Test getItem returns null when no item is found
     */
    public function testGetItemReturnsNullWhenNoItemFound()
    {
        $mock_response = [
            'ItemsResult' => [
                'Items' => []
            ]
        ];
        
        $mock = new MockHandler([
            new Response(200, [], json_encode($mock_response))
        ]);
        
        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);
        
        $api = new AmazonProductApi(
            'test-access-key',
            'test-secret-key',
            'test-partner-tag'
        );
        
        $reflection = new ReflectionClass($api);
        $http_client_prop = $reflection->getProperty('http_client');
        $http_client_prop->setAccessible(true);
        $http_client_prop->setValue($api, $client);
        
        $result = $api->getItem('B07PDHSJ1H');
        
        $this->assertNull($result);
    }

    /**
     * Test getItem with invalid ASIN
     */
    public function testGetItemWithInvalidAsin()
    {
        $api = new AmazonProductApi(
            'test-access-key',
            'test-secret-key',
            'test-partner-tag'
        );
        
        $this->expectException(\InvalidArgumentException::class);
        $api->getItem('invalid-asin');
    }

    /**
     * Test getItem with malformed response
     */
    public function testGetItemWithMalformedResponse()
    {
        $mock = new MockHandler([
            new Response(200, [], 'invalid-json')
        ]);
        
        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);
        
        $api = new AmazonProductApi(
            'test-access-key',
            'test-secret-key',
            'test-partner-tag'
        );
        
        $reflection = new ReflectionClass($api);
        $http_client_prop = $reflection->getProperty('http_client');
        $http_client_prop->setAccessible(true);
        $http_client_prop->setValue($api, $client);
        
        $this->expectException(AmazonAdvertisingApiException::class);
        $api->getItem('B07PDHSJ1H');
    }
} 