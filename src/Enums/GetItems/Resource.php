<?php

namespace GalahadXVI\AmazonProductApi\Enums\GetItems;

/**
 * Class Resource
 *
 * Contains constants for Amazon Product Advertising API resource types
 *
 * @package GalahadXVI\AmazonProductApi\Enums
 */
class Resource
{
    const BROWSE_NODE_INFOBROWSE_NODES = 'BrowseNodeInfo.BrowseNodes';
    const BROWSE_NODE_INFOBROWSE_NODESANCESTOR = 'BrowseNodeInfo.BrowseNodes.Ancestor';
    const BROWSE_NODE_INFOBROWSE_NODESSALES_RANK = 'BrowseNodeInfo.BrowseNodes.SalesRank';
    const BROWSE_NODE_INFOWEBSITE_SALES_RANK = 'BrowseNodeInfo.WebsiteSalesRank';
    const CUSTOMER_REVIEWSCOUNT = 'CustomerReviews.Count';
    const CUSTOMER_REVIEWSSTAR_RATING = 'CustomerReviews.StarRating';
    const IMAGESPRIMARYSMALL = 'Images.Primary.Small';
    const IMAGESPRIMARYMEDIUM = 'Images.Primary.Medium';
    const IMAGESPRIMARYLARGE = 'Images.Primary.Large';
    const IMAGESVARIANTSSMALL = 'Images.Variants.Small';
    const IMAGESVARIANTSMEDIUM = 'Images.Variants.Medium';
    const IMAGESVARIANTSLARGE = 'Images.Variants.Large';
    const ITEM_INFOBY_LINE_INFO = 'ItemInfo.ByLineInfo';
    const ITEM_INFOCONTENT_INFO = 'ItemInfo.ContentInfo';
    const ITEM_INFOCONTENT_RATING = 'ItemInfo.ContentRating';
    const ITEM_INFOCLASSIFICATIONS = 'ItemInfo.Classifications';
    const ITEM_INFOEXTERNAL_IDS = 'ItemInfo.ExternalIds';
    const ITEM_INFOFEATURES = 'ItemInfo.Features';
    const ITEM_INFOMANUFACTURE_INFO = 'ItemInfo.ManufactureInfo';
    const ITEM_INFOPRODUCT_INFO = 'ItemInfo.ProductInfo';
    const ITEM_INFOTECHNICAL_INFO = 'ItemInfo.TechnicalInfo';
    const ITEM_INFOTITLE = 'ItemInfo.Title';
    const ITEM_INFOTRADE_IN_INFO = 'ItemInfo.TradeInInfo';
    const OFFERSLISTINGSAVAILABILITYMAX_ORDER_QUANTITY = 'Offers.Listings.Availability.MaxOrderQuantity';
    const OFFERSLISTINGSAVAILABILITYMESSAGE = 'Offers.Listings.Availability.Message';
    const OFFERSLISTINGSAVAILABILITYMIN_ORDER_QUANTITY = 'Offers.Listings.Availability.MinOrderQuantity';
    const OFFERSLISTINGSAVAILABILITYTYPE = 'Offers.Listings.Availability.Type';
    const OFFERSLISTINGSCONDITION = 'Offers.Listings.Condition';
    const OFFERSLISTINGSCONDITIONCONDITION_NOTE = 'Offers.Listings.Condition.ConditionNote';
    const OFFERSLISTINGSCONDITIONSUB_CONDITION = 'Offers.Listings.Condition.SubCondition';
    const OFFERSLISTINGSDELIVERY_INFOIS_AMAZON_FULFILLED = 'Offers.Listings.DeliveryInfo.IsAmazonFulfilled';
    const OFFERSLISTINGSDELIVERY_INFOIS_FREE_SHIPPING_ELIGIBLE = 'Offers.Listings.DeliveryInfo.IsFreeShippingEligible';
    const OFFERSLISTINGSDELIVERY_INFOIS_PRIME_ELIGIBLE = 'Offers.Listings.DeliveryInfo.IsPrimeEligible';
    const OFFERSLISTINGSDELIVERY_INFOSHIPPING_CHARGES = 'Offers.Listings.DeliveryInfo.ShippingCharges';
    const OFFERSLISTINGSIS_BUY_BOX_WINNER = 'Offers.Listings.IsBuyBoxWinner';
    const OFFERSLISTINGSLOYALTY_POINTSPOINTS = 'Offers.Listings.LoyaltyPoints.Points';
    const OFFERSLISTINGSMERCHANT_INFO = 'Offers.Listings.MerchantInfo';
    const OFFERSLISTINGSPRICE = 'Offers.Listings.Price';
    const OFFERSLISTINGSPROGRAM_ELIGIBILITYIS_PRIME_EXCLUSIVE = 'Offers.Listings.ProgramEligibility.IsPrimeExclusive';
    const OFFERSLISTINGSPROGRAM_ELIGIBILITYIS_PRIME_PANTRY = 'Offers.Listings.ProgramEligibility.IsPrimePantry';
    const OFFERSLISTINGSPROMOTIONS = 'Offers.Listings.Promotions';
    const OFFERSLISTINGSSAVING_BASIS = 'Offers.Listings.SavingBasis';
    const OFFERSSUMMARIESHIGHEST_PRICE = 'Offers.Summaries.HighestPrice';
    const OFFERSSUMMARIESLOWEST_PRICE = 'Offers.Summaries.LowestPrice';
    const OFFERSSUMMARIESOFFER_COUNT = 'Offers.Summaries.OfferCount';
    const PARENT_ASIN = 'ParentASIN';
    const RENTAL_OFFERSLISTINGSAVAILABILITYMAX_ORDER_QUANTITY = 'RentalOffers.Listings.Availability.MaxOrderQuantity';
    const RENTAL_OFFERSLISTINGSAVAILABILITYMESSAGE = 'RentalOffers.Listings.Availability.Message';
    const RENTAL_OFFERSLISTINGSAVAILABILITYMIN_ORDER_QUANTITY = 'RentalOffers.Listings.Availability.MinOrderQuantity';
    const RENTAL_OFFERSLISTINGSAVAILABILITYTYPE = 'RentalOffers.Listings.Availability.Type';
    const RENTAL_OFFERSLISTINGSBASE_PRICE = 'RentalOffers.Listings.BasePrice';
    const RENTAL_OFFERSLISTINGSCONDITION = 'RentalOffers.Listings.Condition';
    const RENTAL_OFFERSLISTINGSCONDITIONCONDITION_NOTE = 'RentalOffers.Listings.Condition.ConditionNote';
    const RENTAL_OFFERSLISTINGSCONDITIONSUB_CONDITION = 'RentalOffers.Listings.Condition.SubCondition';
    const RENTAL_OFFERSLISTINGSDELIVERY_INFOIS_AMAZON_FULFILLED = 'RentalOffers.Listings.DeliveryInfo.IsAmazonFulfilled';
    const RENTAL_OFFERSLISTINGSDELIVERY_INFOIS_FREE_SHIPPING_ELIGIBLE = 'RentalOffers.Listings.DeliveryInfo.IsFreeShippingEligible';
    const RENTAL_OFFERSLISTINGSDELIVERY_INFOIS_PRIME_ELIGIBLE = 'RentalOffers.Listings.DeliveryInfo.IsPrimeEligible';
    const RENTAL_OFFERSLISTINGSDELIVERY_INFOSHIPPING_CHARGES = 'RentalOffers.Listings.DeliveryInfo.ShippingCharges';
    const RENTAL_OFFERSLISTINGSMERCHANT_INFO = 'RentalOffers.Listings.MerchantInfo';
    const OFFERS_V2LISTINGSAVAILABILITY = 'OffersV2.Listings.Availability';
    const OFFERS_V2LISTINGSCONDITION = 'OffersV2.Listings.Condition';
    const OFFERS_V2LISTINGSDEAL_DETAILS = 'OffersV2.Listings.DealDetails';
    const OFFERS_V2LISTINGSIS_BUY_BOX_WINNER = 'OffersV2.Listings.IsBuyBoxWinner';
    const OFFERS_V2LISTINGSLOYALTY_POINTS = 'OffersV2.Listings.LoyaltyPoints';
    const OFFERS_V2LISTINGSMERCHANT_INFO = 'OffersV2.Listings.MerchantInfo';
    const OFFERS_V2LISTINGSPRICE = 'OffersV2.Listings.Price';
    const OFFERS_V2LISTINGSTYPE = 'OffersV2.Listings.Type';

    /**
     * Gets allowable values of the enum
     *
     * @return string[]
     */
    public static function getAllowableEnumValues(): array
    {
        return [
            self::BROWSE_NODE_INFOBROWSE_NODES,
            self::BROWSE_NODE_INFOBROWSE_NODESANCESTOR,
            self::BROWSE_NODE_INFOBROWSE_NODESSALES_RANK,
            self::BROWSE_NODE_INFOWEBSITE_SALES_RANK,
            self::CUSTOMER_REVIEWSCOUNT,
            self::CUSTOMER_REVIEWSSTAR_RATING,
            self::IMAGESPRIMARYSMALL,
            self::IMAGESPRIMARYMEDIUM,
            self::IMAGESPRIMARYLARGE,
            self::IMAGESVARIANTSSMALL,
            self::IMAGESVARIANTSMEDIUM,
            self::IMAGESVARIANTSLARGE,
            self::ITEM_INFOBY_LINE_INFO,
            self::ITEM_INFOCONTENT_INFO,
            self::ITEM_INFOCONTENT_RATING,
            self::ITEM_INFOCLASSIFICATIONS,
            self::ITEM_INFOEXTERNAL_IDS,
            self::ITEM_INFOFEATURES,
            self::ITEM_INFOMANUFACTURE_INFO,
            self::ITEM_INFOPRODUCT_INFO,
            self::ITEM_INFOTECHNICAL_INFO,
            self::ITEM_INFOTITLE,
            self::ITEM_INFOTRADE_IN_INFO,
            self::OFFERSLISTINGSAVAILABILITYMAX_ORDER_QUANTITY,
            self::OFFERSLISTINGSAVAILABILITYMESSAGE,
            self::OFFERSLISTINGSAVAILABILITYMIN_ORDER_QUANTITY,
            self::OFFERSLISTINGSAVAILABILITYTYPE,
            self::OFFERSLISTINGSCONDITION,
            self::OFFERSLISTINGSCONDITIONCONDITION_NOTE,
            self::OFFERSLISTINGSCONDITIONSUB_CONDITION,
            self::OFFERSLISTINGSDELIVERY_INFOIS_AMAZON_FULFILLED,
            self::OFFERSLISTINGSDELIVERY_INFOIS_FREE_SHIPPING_ELIGIBLE,
            self::OFFERSLISTINGSDELIVERY_INFOIS_PRIME_ELIGIBLE,
            self::OFFERSLISTINGSDELIVERY_INFOSHIPPING_CHARGES,
            self::OFFERSLISTINGSIS_BUY_BOX_WINNER,
            self::OFFERSLISTINGSLOYALTY_POINTSPOINTS,
            self::OFFERSLISTINGSMERCHANT_INFO,
            self::OFFERSLISTINGSPRICE,
            self::OFFERSLISTINGSPROGRAM_ELIGIBILITYIS_PRIME_EXCLUSIVE,
            self::OFFERSLISTINGSPROGRAM_ELIGIBILITYIS_PRIME_PANTRY,
            self::OFFERSLISTINGSPROMOTIONS,
            self::OFFERSLISTINGSSAVING_BASIS,
            self::OFFERSSUMMARIESHIGHEST_PRICE,
            self::OFFERSSUMMARIESLOWEST_PRICE,
            self::OFFERSSUMMARIESOFFER_COUNT,
            self::PARENT_ASIN,
            self::RENTAL_OFFERSLISTINGSAVAILABILITYMAX_ORDER_QUANTITY,
            self::RENTAL_OFFERSLISTINGSAVAILABILITYMESSAGE,
            self::RENTAL_OFFERSLISTINGSAVAILABILITYMIN_ORDER_QUANTITY,
            self::RENTAL_OFFERSLISTINGSAVAILABILITYTYPE,
            self::RENTAL_OFFERSLISTINGSBASE_PRICE,
            self::RENTAL_OFFERSLISTINGSCONDITION,
            self::RENTAL_OFFERSLISTINGSCONDITIONCONDITION_NOTE,
            self::RENTAL_OFFERSLISTINGSCONDITIONSUB_CONDITION,
            self::RENTAL_OFFERSLISTINGSDELIVERY_INFOIS_AMAZON_FULFILLED,
            self::RENTAL_OFFERSLISTINGSDELIVERY_INFOIS_FREE_SHIPPING_ELIGIBLE,
            self::RENTAL_OFFERSLISTINGSDELIVERY_INFOIS_PRIME_ELIGIBLE,
            self::RENTAL_OFFERSLISTINGSDELIVERY_INFOSHIPPING_CHARGES,
            self::RENTAL_OFFERSLISTINGSMERCHANT_INFO,
            self::OFFERS_V2LISTINGSAVAILABILITY,
            self::OFFERS_V2LISTINGSCONDITION,
            self::OFFERS_V2LISTINGSDEAL_DETAILS,
            self::OFFERS_V2LISTINGSIS_BUY_BOX_WINNER,
            self::OFFERS_V2LISTINGSLOYALTY_POINTS,
            self::OFFERS_V2LISTINGSMERCHANT_INFO,
            self::OFFERS_V2LISTINGSPRICE,
            self::OFFERS_V2LISTINGSTYPE,
        ];
    }
}