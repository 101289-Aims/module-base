<?php
/**
 * Aimsinfosoft
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Aimsinfosoft.com license that is
 * available through the world-wide-web at this URL:
 * https://www.aimsinfosoft.com/LICENSE.txt
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Aimsinfosoft
 * @package     Aimsinfosoft_Base
 * @copyright   Copyright (c) Aimsinfosoft (https://www.aimsinfosoft.com/)
 * @license     https://www.aimsinfosoft.com/LICENSE.txt
 */

declare(strict_types=1);

namespace Aimsinfosoft\Base\Model\Feed\FeedTypes;

use Aimsinfosoft\Base\Model\Feed\FeedContentProvider;
use Aimsinfosoft\Base\Model\ModuleInfoProvider;
use Aimsinfosoft\Base\Model\Parser;
use Aimsinfosoft\Base\Model\Serializer;
use Magento\Framework\Config\CacheInterface;

class Ads
{
    public const CSV_CACHE_ID = 'Aimsinfosoft_base_csv';
    public const Aimsinfosoft_ADS_LAST_MODIFIED_DATE = 'Aimsinfosoft_ads_last_modified_date';

    /**
     * @var CacheInterface
     */
    private $cache;

    /**
     * @var Serializer
     */
    private $serializer;

    /**
     * @var FeedContentProvider
     */
    private $feedContentProvider;

    /**
     * @var Parser
     */
    private $parser;

    /**
     * @var Ad\Offline
     */
    private $adOffline;

    /**
     * @var ModuleInfoProvider
     */
    private $moduleInfoProvider;

    public function __construct(
        CacheInterface $cache,
        Serializer $serializer,
        FeedContentProvider $feedContentProvider,
        Parser $parser,
        Ad\Offline $adOffline,
        ModuleInfoProvider $moduleInfoProvider
    ) {
        $this->cache = $cache;
        $this->serializer = $serializer;
        $this->feedContentProvider = $feedContentProvider;
        $this->parser = $parser;
        $this->adOffline = $adOffline;
        $this->moduleInfoProvider = $moduleInfoProvider;
    }

    /**
     * @return array
     */
    public function execute(): array
    {
        $cache = $this->cache->load(self::CSV_CACHE_ID);
        $unserializedCache = $cache ? $this->serializer->unserialize($cache) : null;

        return $unserializedCache ?: $this->getFeed();
    }

    /**
     * @return array
     */
    public function getFeed(): array
    {
        $result = [];
        $cachedData = $this->cache->load(self::CSV_CACHE_ID);
        $options = $cachedData ? ['modified_since' => $this->getLastModified()] : [];
        $feedResponse = $this->feedContentProvider->getFeedResponse(
            $this->feedContentProvider->getFeedUrl(FeedContentProvider::URN_ADS),
            $options
        );

        if (!$this->moduleInfoProvider->isOriginMarketplace()) {

            if ($feedResponse->isNeedToUpdateCache()) {
                $result = $this->parser->parseCsv($feedResponse->getContent());
                $result = $this->parser->trimCsvData($result, ['upsell_module_code', 'module_code']);
                $this->saveCache($result);
                $this->setLastModified();
            }
        }

        if (!$result || $feedResponse->isFailed()) {
            $result = $this->adOffline->getOfflineData($this->moduleInfoProvider->isOriginMarketplace());
            $result = $this->parser->trimCsvData($result, ['upsell_module_code', 'module_code']);
            $this->saveCache($result);

        }
        return $result;
    }

    private function getLastModified()
    {
        return $this->cache->load(self::Aimsinfosoft_ADS_LAST_MODIFIED_DATE);
    }

    private function setLastModified()
    {
        $dateTime = gmdate('D, d M Y H:i:s') . ' GMT';

        return $this->cache->save($dateTime, self::Aimsinfosoft_ADS_LAST_MODIFIED_DATE);
    }

    private function saveCache(array $result)
    {
        $this->cache->save(
            $this->serializer->serialize($result),
            self::CSV_CACHE_ID,
            [self::CSV_CACHE_ID]
        );
    }
}
