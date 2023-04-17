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


namespace Aimsinfosoft\Base\Model;

/**
 * Class MagentoVersion is used for faster retrieving magento version
 */
class MagentoVersion
{
    public const MAGENTO_VERSION = 'Aimsinfosoft_magento_version';

    /**
     * @var \Magento\Framework\App\ProductMetadataInterface
     */
    private $productMetadata;

    /**
     * @var \Magento\Framework\App\Cache\Type\Config
     */
    private $cache;

    /**
     * @var string
     */
    private $magentoVersion;

    public function __construct(
        \Magento\Framework\App\Cache\Type\Config $cache,
        \Magento\Framework\App\ProductMetadataInterface $productMetadata
    ) {
        $this->productMetadata = $productMetadata;
        $this->cache = $cache;
    }

    /**
     * @return string
     */
    public function get()
    {
        if (!$this->magentoVersion
            && !($this->magentoVersion = $this->cache->load(self::MAGENTO_VERSION))
        ) {
            $this->magentoVersion = $this->productMetadata->getVersion();
            $this->cache->save($this->magentoVersion, self::MAGENTO_VERSION);
        }

        return $this->magentoVersion;
    }
}
