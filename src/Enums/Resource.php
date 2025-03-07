<?php

namespace GalahadXVI\AmazonProductApi\Enums;

/**
 * Class Resource
 * 
 * Contains constants for Amazon Product Advertising API resource types
 * 
 * @package GalahadXVI\AmazonProductApi\Enums
 */
class Resource
{
    // Browse Node Info
    public const BROWSE_NODE_INFO_BROWSE_NODES = 'BrowseNodeInfo.BrowseNodes';
    public const BROWSE_NODE_INFO_BROWSE_NODES_ANCESTOR = 'BrowseNodeInfo.BrowseNodes.Ancestor';
    public const BROWSE_NODE_INFO_BROWSE_NODES_SALES_RANK = 'BrowseNodeInfo.BrowseNodes.SalesRank';
    public const BROWSE_NODE_INFO_WEBSITE_SALES_RANK = 'BrowseNodeInfo.WebsiteSalesRank';
    
    // Item Info
    public const ITEM_INFO_BY_LINE_INFO = 'ItemInfo.ByLineInfo';
    public const ITEM_INFO_CLASSIFICATIONS = 'ItemInfo.Classifications';
    public const ITEM_INFO_CONTENT_INFO = 'ItemInfo.ContentInfo';
    public const ITEM_INFO_CONTENT_RATING = 'ItemInfo.ContentRating';
    public const ITEM_INFO_EXTERNAL_IDS = 'ItemInfo.ExternalIds';
    public const ITEM_INFO_FEATURES = 'ItemInfo.Features';
    public const ITEM_INFO_MANUFACTURER_INFO = 'ItemInfo.ManufactureInfo';
    public const ITEM_INFO_PRODUCT_INFO = 'ItemInfo.ProductInfo';
    public const ITEM_INFO_TECHNICAL_INFO = 'ItemInfo.TechnicalInfo';
    public const ITEM_INFO_TITLE = 'ItemInfo.Title';
    public const ITEM_INFO_TRADE_IN_INFO = 'ItemInfo.TradeInInfo';
    
    // Offers
    public const OFFERS_LISTINGS = 'Offers.Listings';
    public const OFFERS_SUMMARIES = 'Offers.Summaries';
    
    // Parent ASINs
    public const PARENT_ASIN = 'ParentASIN';
    
    // Images
    public const IMAGES_PRIMARY = 'Images.Primary';
    public const IMAGES_VARIANTS = 'Images.Variants';
    
    // Accessories
    public const ITEM_ACCESSORIES = 'CustomerReviews.Count';
    public const CUSTOMER_REVIEWS_STAR_RATING = 'CustomerReviews.StarRating';
    
    /**
     * Get all available resources
     * 
     * @return array
     */
    public static function getAllResources(): array
    {
        return [
            self::BROWSE_NODE_INFO_BROWSE_NODES,
            self::BROWSE_NODE_INFO_BROWSE_NODES_ANCESTOR,
            self::BROWSE_NODE_INFO_BROWSE_NODES_SALES_RANK,
            self::BROWSE_NODE_INFO_WEBSITE_SALES_RANK,
            self::ITEM_INFO_BY_LINE_INFO,
            self::ITEM_INFO_CLASSIFICATIONS,
            self::ITEM_INFO_CONTENT_INFO,
            self::ITEM_INFO_CONTENT_RATING,
            self::ITEM_INFO_EXTERNAL_IDS,
            self::ITEM_INFO_FEATURES,
            self::ITEM_INFO_MANUFACTURER_INFO,
            self::ITEM_INFO_PRODUCT_INFO,
            self::ITEM_INFO_TECHNICAL_INFO,
            self::ITEM_INFO_TITLE,
            self::ITEM_INFO_TRADE_IN_INFO,
            self::OFFERS_LISTINGS,
            self::OFFERS_SUMMARIES,
            self::PARENT_ASIN,
            self::IMAGES_PRIMARY,
            self::IMAGES_VARIANTS,
            self::ITEM_ACCESSORIES,
            self::CUSTOMER_REVIEWS_STAR_RATING,
        ];
    }
} 