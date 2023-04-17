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


namespace Aimsinfosoft\Base\Model\Feed;

use Aimsinfosoft\Base\Model\AdminNotification\Model\ResourceModel\Inbox\Collection\Expired;
use Aimsinfosoft\Base\Model\AdminNotification\Model\ResourceModel\Inbox\Collection\ExpiredFactory;
use Aimsinfosoft\Base\Model\Config;
use Aimsinfosoft\Base\Model\Feed\FeedTypes\News;
use Magento\AdminNotification\Model\Inbox;
use Magento\AdminNotification\Model\InboxFactory;

class NewsProcessor
{
    /**
     * @var Config
     */
    private $config;

    /**
     * @var InboxFactory
     */
    private $inboxFactory;

    /**
     * @var ExpiredFactory
     */
    private $expiredFactory;

    /**
     * @var FeedTypes\News
     */
    private $newsFeed;

    public function __construct(
        Config $config,
        InboxFactory $inboxFactory,
        ExpiredFactory $expiredFactory,
        News $newsFeed
    ) {
        $this->config = $config;
        $this->inboxFactory = $inboxFactory;
        $this->expiredFactory = $expiredFactory;
        $this->newsFeed = $newsFeed;
    }

    /**
     * @return void
     */
    public function checkUpdate()
    {
          
          //comment lines 72 to 75
        // if ($this->config->getFrequencyInSec() + $this->config->getLastUpdate() > time()) {
        //     return;
        // }
        if ($feedData = $this->newsFeed->execute()) {
            /** @var Inbox $inbox */

            $inbox = $this->inboxFactory->create();
            $inbox->parse([$feedData]);
        }
        $this->config->setLastUpdate();
    }

    /**
     * @return void
     */
    public function removeExpiredItems()
    {
        if ($this->config->getLastRemovement() + Config::REMOVE_EXPIRED_FREQUENCY > time()) {
            return;
        }

        /** @var Expired $collection */
        $collection = $this->expiredFactory->create();
        foreach ($collection as $model) {
            $model->setIsRemove(1)->save();
        }
        $this->config->setLastRemovement();
    }
}
