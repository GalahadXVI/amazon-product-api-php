<?php

namespace Custom\AmazonAdvertisingApi\Tests\Authentication;

use Custom\AmazonAdvertisingApi\Authentication\AwsV4Signer;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

/**
 * Class AwsV4SignerTest
 * 
 * Tests for the AwsV4Signer class
 * 
 * @package Custom\AmazonAdvertisingApi\Tests\Authentication
 */
class AwsV4SignerTest extends TestCase
{
    /**
     * Test constructor sets properties correctly
     */
    public function testConstructorSetsPropertiesCorrectly()
    {
        $signer = new AwsV4Signer('test-access-key', 'test-secret-key');
        
        $reflection = new ReflectionClass($signer);
        
        $access_key_prop = $reflection->getProperty('access_key');
        $access_key_prop->setAccessible(true);
        $this->assertEquals('test-access-key', $access_key_prop->getValue($signer));
        
        $secret_key_prop = $reflection->getProperty('secret_key');
        $secret_key_prop->setAccessible(true);
        $this->assertEquals('test-secret-key', $secret_key_prop->getValue($signer));
        
        $x_amz_date_prop = $reflection->getProperty('x_amz_date');
        $x_amz_date_prop->setAccessible(true);
        $this->assertNotNull($x_amz_date_prop->getValue($signer));
        
        $current_date_prop = $reflection->getProperty('current_date');
        $current_date_prop->setAccessible(true);
        $this->assertNotNull($current_date_prop->getValue($signer));
    }
    
    /**
     * Test header addition and fluent interface
     */
    public function testAddHeader()
    {
        $signer = new AwsV4Signer('test-access-key', 'test-secret-key');
        
        $return = $signer->addHeader('Content-Type', 'application/json');
        
        $this->assertSame($signer, $return);
        
        $reflection = new ReflectionClass($signer);
        $aws_headers_prop = $reflection->getProperty('aws_headers');
        $aws_headers_prop->setAccessible(true);
        
        $headers = $aws_headers_prop->getValue($signer);
        $this->assertArrayHasKey('content-type', $headers);
        $this->assertEquals('application/json', $headers['content-type']);
    }
    
    /**
     * Test setting path and fluent interface
     */
    public function testSetPath()
    {
        $signer = new AwsV4Signer('test-access-key', 'test-secret-key');
        
        $return = $signer->setPath('/test/path');
        
        $this->assertSame($signer, $return);
        
        $reflection = new ReflectionClass($signer);
        $path_prop = $reflection->getProperty('path');
        $path_prop->setAccessible(true);
        
        $this->assertEquals('/test/path', $path_prop->getValue($signer));
    }
    
    /**
     * Test setting service name and fluent interface
     */
    public function testSetServiceName()
    {
        $signer = new AwsV4Signer('test-access-key', 'test-secret-key');
        
        $return = $signer->setServiceName('TestService');
        
        $this->assertSame($signer, $return);
        
        $reflection = new ReflectionClass($signer);
        $service_name_prop = $reflection->getProperty('service_name');
        $service_name_prop->setAccessible(true);
        
        $this->assertEquals('TestService', $service_name_prop->getValue($signer));
    }
    
    /**
     * Test setting region name and fluent interface
     */
    public function testSetRegionName()
    {
        $signer = new AwsV4Signer('test-access-key', 'test-secret-key');
        
        $return = $signer->setRegionName('eu-west-1');
        
        $this->assertSame($signer, $return);
        
        $reflection = new ReflectionClass($signer);
        $region_name_prop = $reflection->getProperty('region_name');
        $region_name_prop->setAccessible(true);
        
        $this->assertEquals('eu-west-1', $region_name_prop->getValue($signer));
    }
    
    /**
     * Test setting payload and fluent interface
     */
    public function testSetPayload()
    {
        $signer = new AwsV4Signer('test-access-key', 'test-secret-key');
        
        $return = $signer->setPayload('{"test":"value"}');
        
        $this->assertSame($signer, $return);
        
        $reflection = new ReflectionClass($signer);
        $payload_prop = $reflection->getProperty('payload');
        $payload_prop->setAccessible(true);
        
        $this->assertEquals('{"test":"value"}', $payload_prop->getValue($signer));
    }
    
    /**
     * Test setting request method and fluent interface
     */
    public function testSetRequestMethod()
    {
        $signer = new AwsV4Signer('test-access-key', 'test-secret-key');
        
        $return = $signer->setRequestMethod('POST');
        
        $this->assertSame($signer, $return);
        
        $reflection = new ReflectionClass($signer);
        $http_method_name_prop = $reflection->getProperty('http_method_name');
        $http_method_name_prop->setAccessible(true);
        
        $this->assertEquals('POST', $http_method_name_prop->getValue($signer));
    }
    
    /**
     * Test that getHeaders returns expected headers
     */
    public function testGetHeadersReturnsExpectedHeaders()
    {
        $signer = new AwsV4Signer('test-access-key', 'test-secret-key');
        $signer->setPath('/test/path');
        $signer->setServiceName('TestService');
        $signer->setRegionName('eu-west-1');
        $signer->setPayload('{"test":"value"}');
        $signer->setRequestMethod('POST');
        $signer->addHeader('host', 'example.com');
        
        $headers = $signer->getHeaders();
        
        $this->assertArrayHasKey('host', $headers);
        $this->assertArrayHasKey('x-amz-date', $headers);
        $this->assertArrayHasKey('Authorization', $headers);
        
        // Test that the Authorization header has the expected format
        $this->assertStringContainsString('AWS4-HMAC-SHA256', $headers['Authorization']);
        $this->assertStringContainsString('Credential=test-access-key/', $headers['Authorization']);
        $this->assertStringContainsString('/eu-west-1/TestService/aws4_request', $headers['Authorization']);
        $this->assertStringContainsString('SignedHeaders=', $headers['Authorization']);
        $this->assertStringContainsString('Signature=', $headers['Authorization']);
    }
} 