<?php

namespace GalahadXVI\AmazonProductApi\Authentication;

/**
 * Class AwsV4Signer
 * 
 * Handles AWS v4 signature generation for Amazon Product Advertising API requests
 * 
 * @package GalahadXVI\AmazonProductApi\Authentication
 */
class AwsV4Signer
{
    /**
     * AWS access key
     * 
     * @var string|null
     */
    private $access_key = null;
    
    /**
     * AWS secret key
     * 
     * @var string|null
     */
    private $secret_key = null;
    
    /**
     * Request path
     * 
     * @var string|null
     */
    private $path = null;
    
    /**
     * AWS region name
     * 
     * @var string|null
     */
    private $region_name = null;
    
    /**
     * AWS service name
     * 
     * @var string|null
     */
    private $service_name = null;
    
    /**
     * HTTP method (GET, POST, etc.)
     * 
     * @var string|null
     */
    private $http_method_name = null;
    
    /**
     * Headers to be signed
     * 
     * @var array
     */
    private $aws_headers = [];
    
    /**
     * Request payload
     * 
     * @var string
     */
    private $payload = "";
    
    /**
     * HMAC algorithm for signature
     * 
     * @var string
     */
    private $HMAC_algorithm = "AWS4-HMAC-SHA256";
    
    /**
     * Request type
     * 
     * @var string
     */
    private $aws4_request = "aws4_request";
    
    /**
     * String of signed headers
     * 
     * @var string|null
     */
    private $str_signed_header = null;
    
    /**
     * Formatted timestamp for x-amz-date header
     * 
     * @var string|null
     */
    private $x_amz_date = null;
    
    /**
     * Current date in YYYYMMDD format
     * 
     * @var string|null
     */
    private $current_date = null;

    /**
     * Constructor
     * 
     * @param string $access_key AWS access key
     * @param string $secret_key AWS secret key
     */
    public function __construct(string $access_key, string $secret_key)
    {
        $this->access_key = $access_key;
        $this->secret_key = $secret_key;
        $this->x_amz_date = $this->getTimestamp();
        $this->current_date = $this->getDate();
    }

    /**
     * Set the request path
     * 
     * @param string $path Request path
     * @return self
     */
    public function setPath(string $path): self
    {
        $this->path = $path;
        return $this;
    }

    /**
     * Set the AWS service name
     * 
     * @param string $service_name Service name
     * @return self
     */
    public function setServiceName(string $service_name): self
    {
        $this->service_name = $service_name;
        return $this;
    }

    /**
     * Set the AWS region name
     * 
     * @param string $region_name Region name
     * @return self
     */
    public function setRegionName(string $region_name): self
    {
        $this->region_name = $region_name;
        return $this;
    }

    /**
     * Set the request payload
     * 
     * @param string $payload Request payload
     * @return self
     */
    public function setPayload(string $payload): self
    {
        $this->payload = $payload;
        return $this;
    }

    /**
     * Set the HTTP request method
     * 
     * @param string $method HTTP method (GET, POST, etc.)
     * @return self
     */
    public function setRequestMethod(string $method): self
    {
        $this->http_method_name = $method;
        return $this;
    }

    /**
     * Add a header to be included in the signature
     * 
     * @param string $header_name Header name
     * @param string $header_value Header value
     * @return self
     */
    public function addHeader(string $header_name, string $header_value): self
    {
        $this->aws_headers[strtolower($header_name)] = trim($header_value);
        return $this;
    }

    /**
     * Prepare the canonical request for AWS signature
     * 
     * @return string
     */
    private function prepareCanonicalRequest(): string
    {
        $canonical_request = $this->http_method_name . "\n";
        $canonical_request .= $this->path . "\n" . "\n";

        $signed_headers = '';
        ksort($this->aws_headers);
        foreach ($this->aws_headers as $key => $value) {
            $signed_headers .= $key . ";";
            $canonical_request .= $key . ":" . $value . "\n";
        }
        $canonical_request .= "\n";
        $this->str_signed_header = rtrim($signed_headers, ";");
        $canonical_request .= $this->str_signed_header . "\n";
        $canonical_request .= $this->generateHex($this->payload);
        
        return $canonical_request;
    }

    /**
     * Prepare the string to sign for AWS signature
     * 
     * @param string $canonical_request
     * @return string
     */
    private function prepareStringToSign(string $canonical_request): string
    {
        $string_to_sign = "";
        $string_to_sign .= $this->HMAC_algorithm . "\n";
        $string_to_sign .= $this->x_amz_date . "\n";
        $string_to_sign .= $this->current_date . "/" . $this->region_name . "/" . $this->service_name . "/" . $this->aws4_request . "\n";
        $string_to_sign .= $this->generateHex($canonical_request);
        
        return $string_to_sign;
    }

    /**
     * Calculate the signature for the request
     * 
     * @param string $string_to_sign
     * @return string
     */
    private function calculateSignature(string $string_to_sign): string
    {
        $signature_key = $this->getSignatureKey($this->secret_key, $this->current_date, $this->region_name, $this->service_name);
        $signature = hash_hmac("sha256", $string_to_sign, $signature_key, true);
        
        return strtolower(bin2hex($signature));
    }

    /**
     * Get the headers with signature
     * 
     * @return array
     */
    public function getHeaders(): array
    {
        // Add the x-amz-date header to be signed
        $this->aws_headers['x-amz-date'] = $this->x_amz_date;
        ksort($this->aws_headers);

        // Step 1: Create canonical request
        $canonical_request = $this->prepareCanonicalRequest();

        // Step 2: Create string to sign
        $string_to_sign = $this->prepareStringToSign($canonical_request);

        // Step 3: Calculate the signature
        $signature = $this->calculateSignature($string_to_sign);

        // Step 4: Build the Authorization header
        if ($signature) {
            $this->aws_headers['Authorization'] = $this->buildAuthorizationString($signature);
            return $this->aws_headers;
        }
        
        return $this->aws_headers;
    }

    /**
     * Build the Authorization header string
     * 
     * @param string $signature
     * @return string
     */
    private function buildAuthorizationString(string $signature): string
    {
        return $this->HMAC_algorithm . " " .
            "Credential=" . $this->access_key . "/" . $this->getDate() . "/" . $this->region_name . "/" . $this->service_name . "/" . $this->aws4_request . ", " .
            "SignedHeaders=" . $this->str_signed_header . ", " .
            "Signature=" . $signature;
    }

    /**
     * Generate hex-encoded SHA-256 hash
     * 
     * @param string $data
     * @return string
     */
    private function generateHex(string $data): string
    {
        return strtolower(bin2hex(hash("sha256", $data, true)));
    }

    /**
     * Generate the AWS signature key
     * 
     * @param string $key Secret key
     * @param string $date Date in YYYYMMDD format
     * @param string $region_name AWS region
     * @param string $service_name AWS service
     * @return string
     */
    private function getSignatureKey(string $key, string $date, string $region_name, string $service_name)
    {
        $k_secret  = "AWS4" . $key;
        $k_date    = hash_hmac("sha256", $date, $k_secret, true);
        $k_region  = hash_hmac("sha256", $region_name, $k_date, true);
        $k_service = hash_hmac("sha256", $service_name, $k_region, true);
        $k_signing = hash_hmac("sha256", $this->aws4_request, $k_service, true);
        
        return $k_signing;
    }

    /**
     * Get timestamp in ISO8601 format
     * 
     * @return string
     */
    private function getTimestamp(): string
    {
        return gmdate("Ymd\THis\Z");
    }

    /**
     * Get date in YYYYMMDD format
     * 
     * @return string
     */
    private function getDate(): string
    {
        return gmdate("Ymd");
    }
} 