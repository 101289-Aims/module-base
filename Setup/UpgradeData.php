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


namespace Aimsinfosoft\Base\Setup;

use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class UpgradeData implements UpgradeDataInterface
{
    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * @var \Magento\Framework\App\State
     */
    private $appState;

    /**
     * @var \Aimsinfosoft\Base\Model\Feed\FeedTypes\Extensions
     */
    private $extensionsFeed;

    public function __construct(
        \Magento\Framework\App\State $appState,
        \Psr\Log\LoggerInterface $logger,
        \Aimsinfosoft\Base\Model\Feed\FeedTypes\Extensions $extensionsFeed
    ) {
        $this->logger = $logger;
        $this->appState = $appState;
        $this->extensionsFeed = $extensionsFeed;
    }

    /**
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface   $context
     * @return void
     */
    public function upgrade(
        ModuleDataSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        $this->appState->emulateAreaCode(
            \Magento\Framework\App\Area::AREA_ADMINHTML,
            [$this, 'upgradeCallback'],
            [$setup, $context]
        );
    }

    /**
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     *
     * @return void
     */
    public function upgradeCallback(
        ModuleDataSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        $setup->startSetup();

        if (version_compare($context->getVersion(), '1.5.0', '<')) {
            try {
                $this->extensionsFeed->getFeed();
            } catch (\Exception $ex) {
                $this->logger->critical($ex);
            }
        }

        $setup->endSetup();
    }
}
