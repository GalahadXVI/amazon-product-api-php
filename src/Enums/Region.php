<?php

namespace GalahadXVI\AmazonProductApi\Enums;

/**
 * Class Region
 * 
 * Contains constants for Amazon Product Advertising API regions
 * 
 * @package GalahadXVI\AmazonProductApi\Enums
 */
class Region
{
    public const AUSTRALIA = 'AU';
    public const BRAZIL = 'BR';
    public const CANADA = 'CA';
    public const FRANCE = 'FR';
    public const GERMANY = 'DE';
    public const INDIA = 'IN';
    public const ITALY = 'IT';
    public const JAPAN = 'JP';
    public const MEXICO = 'MX';
    public const NETHERLANDS = 'NL';
    public const SINGAPORE = 'SG';
    public const SAUDI_ARABIA = 'SA';
    public const SPAIN = 'ES';
    public const SWEDEN = 'SE';
    public const TURKEY = 'TR';
    public const UNITED_ARAB_EMIRATES = 'AE';
    public const UNITED_KINGDOM = 'UK';
    public const UNITED_STATES = 'US';
    
    /**
     * Get the AWS region based on country code
     *
     * @param string $country_code
     * @return string
     */
    public static function getAwsRegion(string $country_code): string
    {
        $regions = [
            self::AUSTRALIA => 'us-west-2',
            self::BRAZIL => 'us-east-1',
            self::CANADA => 'us-east-1',
            self::FRANCE => 'eu-west-1',
            self::GERMANY => 'eu-west-1',
            self::INDIA => 'eu-west-1',
            self::ITALY => 'eu-west-1',
            self::JAPAN => 'us-west-2',
            self::MEXICO => 'us-east-1',
            self::NETHERLANDS => 'eu-west-1',
            self::SINGAPORE => 'us-west-2',
            self::SAUDI_ARABIA => 'eu-west-1',
            self::SPAIN => 'eu-west-1',
            self::SWEDEN => 'eu-west-1',
            self::TURKEY => 'eu-west-1',
            self::UNITED_ARAB_EMIRATES => 'eu-west-1',
            self::UNITED_KINGDOM => 'eu-west-1',
            self::UNITED_STATES => 'us-east-1',
        ];
        
        return $regions[$country_code] ?? 'us-east-1';
    }
    
    /**
     * Get the host domain based on country code
     *
     * @param string $country_code
     * @return string
     */
    public static function getHost(string $country_code): string
    {
        $hosts = [
            self::AUSTRALIA => 'webservices.amazon.com.au',
            self::BRAZIL => 'webservices.amazon.com.br',
            self::CANADA => 'webservices.amazon.ca',
            self::FRANCE => 'webservices.amazon.fr',
            self::GERMANY => 'webservices.amazon.de',
            self::INDIA => 'webservices.amazon.in',
            self::ITALY => 'webservices.amazon.it',
            self::JAPAN => 'webservices.amazon.co.jp',
            self::MEXICO => 'webservices.amazon.com.mx',
            self::NETHERLANDS => 'webservices.amazon.nl',
            self::SINGAPORE => 'webservices.amazon.sg',
            self::SAUDI_ARABIA => 'webservices.amazon.sa',
            self::SPAIN => 'webservices.amazon.es',
            self::SWEDEN => 'webservices.amazon.se',
            self::TURKEY => 'webservices.amazon.com.tr',
            self::UNITED_ARAB_EMIRATES => 'webservices.amazon.ae',
            self::UNITED_KINGDOM => 'webservices.amazon.co.uk',
            self::UNITED_STATES => 'webservices.amazon.com',
        ];
        
        return $hosts[$country_code] ?? 'webservices.amazon.com';
    }

    /**
     * Check if a country code is valid
     *
     * @param string $country_code
     * @return bool
     */
    public static function isValid(string $country_code): bool
    {
        $valid_codes = [
            self::AUSTRALIA,
            self::BRAZIL,
            self::CANADA,
            self::FRANCE,
            self::GERMANY,
            self::INDIA,
            self::ITALY,
            self::JAPAN,
            self::MEXICO,
            self::NETHERLANDS,
            self::SINGAPORE,
            self::SAUDI_ARABIA,
            self::SPAIN,
            self::SWEDEN,
            self::TURKEY,
            self::UNITED_ARAB_EMIRATES,
            self::UNITED_KINGDOM,
            self::UNITED_STATES,
        ];

        return in_array($country_code, $valid_codes, true);
    }
} 