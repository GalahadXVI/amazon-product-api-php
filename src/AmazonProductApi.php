<?php

namespace Custom\AmazonAdvertisingApi;

use Custom\AmazonAdvertisingApi\Authentication\AwsV4Signer;
use Custom\AmazonAdvertisingApi\Enums\Region;
use Custom\AmazonAdvertisingApi\Exception\AmazonAdvertisingApiException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

/**
 * Class AmazonAdvertisingApi
 * 
 * Main client for interacting with Amazon's Product Advertising API 5.0
 * 
 * @package Custom\AmazonAdvertisingApi
 */
class AmazonProductApi
{
    /**
     * Amazon Product Advertising API service name
     */
    private const SERVICE_NAME = 'ProductAdvertisingAPI';
    
    /**
     * API endpoint URI path for GetItems
     */
    private const GET_ITEMS_URI_PATH = '/paapi5/getitems';
    
    /**
     * API target for GetItems operation
     */
    private const GET_ITEMS_TARGET = 'com.amazon.paapi5.v1.ProductAdvertisingAPIv1.GetItems';
    
    /**
     * AWS access key
     * 
     * @var string
     */
    private $access_key;
    
    /**
     * AWS secret key
     * 
     * @var string
     */
    private $secret_key;
    
    /**
     * Amazon Associate/Partner Tag
     * 
     * @var string
     */
    private $partner_tag;
    
    /**
     * Amazon marketplace country code
     * 
     * @var string
     */
    private $country_code;
    
    /**
     * Guzzle HTTP client
     * 
     * @var Client
     */
    private $http_client;

    /**
     * Constructor
     * 
     * @param string $access_key AWS access key
     * @param string $secret_key AWS secret key
     * @param string $partner_tag Amazon Associate/Partner tag
     * @param string $country_code Amazon marketplace country code (default: US)
     */
    public function __construct(string $access_key, string $secret_key, string $partner_tag, string $country_code = Region::UNITED_STATES)
    {
        $this->access_key = $access_key;
        $this->secret_key = $secret_key;
        $this->partner_tag = $partner_tag;
        $this->country_code = $country_code;
        
        $host = Region::getHost($country_code);
        
        $this->http_client = new Client([
            'base_uri' => "https://{$host}",
            'timeout'  => 30.0,
        ]);
    }
    
    /**
     * Get Amazon product items by their ASINs
     * 
     * @param array $item_ids Array of ASINs
     * @param array $resources Array of resources to include in the response
     * @return array
     * @throws AmazonAdvertisingApiException
     */
    public function getItems(array $item_ids, array $resources = []): array
    {
        // Build payload
        $payload = [
            'ItemIds'     => $item_ids,
            'Resources'   => !empty($resources) ? $resources : [
                'ItemInfo.Title',
                'Images.Primary',
                'Offers.Listings',
            ],
            'PartnerTag'  => $this->partner_tag,
            'PartnerType' => 'Associates',
            'Marketplace' => Region::getHost($this->country_code),
        ];
        
        $json_payload = json_encode($payload);
        
        // Get the host and AWS region
        $host = Region::getHost($this->country_code);
        $region = Region::getAwsRegion($this->country_code);
        
        // Initialize the AWS v4 signer
        $aws_v4_signer = new AwsV4Signer($this->access_key, $this->secret_key);
        $aws_v4_signer->setRegionName($region);
        $aws_v4_signer->setServiceName(self::SERVICE_NAME);
        $aws_v4_signer->setPath(self::GET_ITEMS_URI_PATH);
        $aws_v4_signer->setPayload($json_payload);
        $aws_v4_signer->setRequestMethod('POST');
        
        // Add headers that need to be signed
        $aws_v4_signer->addHeader('content-encoding', 'amz-1.0');
        $aws_v4_signer->addHeader('host', $host);
        $aws_v4_signer->addHeader('x-amz-target', self::GET_ITEMS_TARGET);
        
        // Get signed headers
        $signed_headers = $aws_v4_signer->getHeaders();
        
        // Add headers that should be sent but not signed
        $signed_headers['Content-Type'] = 'application/json; charset=UTF-8';
        $signed_headers['Accept'] = 'application/json, text/javascript';
        $signed_headers['Accept-Language'] = 'en-US';
        
        try {
            $response = $this->http_client->request('POST', self::GET_ITEMS_URI_PATH, [
                'headers' => $signed_headers,
                'body'    => $json_payload,
            ]);
            
            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            throw new AmazonAdvertisingApiException("Request failed: " . $e->getMessage(), $e->getCode(), $e);
        }
    }
    
    /**
     * Get a single Amazon product item by its ASIN
     * 
     * @param string $item_id ASIN of the product
     * @param array $resources Array of resources to include in the response
     * @return array|null
     * @throws AmazonAdvertisingApiException
     */
    public function getItem(string $item_id, array $resources = []): ?array
    {
        $response = $this->getItems([$item_id], $resources);
        
        if (isset($response['ItemsResult']['Items'][0])) {
            return $response['ItemsResult']['Items'][0];
        }
        
        return null;
    }
} 