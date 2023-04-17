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

namespace Aimsinfosoft\Base\Cron;

use Aimsinfosoft\Base\Model\Feed\FeedTypes\Ads;
use Aimsinfosoft\Base\Model\Feed\FeedTypes\Extensions;

class RefreshFeedData
{
    /**
     * @var Ads
     */
    private $adsFeed;

    /**
     * @var Extensions
     */
    private $extensionsFeed;

    public function __construct(
        Ads $adsFeed,
        Extensions $extensionsFeed
    ) {
        $this->adsFeed = $adsFeed;
        $this->extensionsFeed = $extensionsFeed;
    }

    /**
     * Force reload feeds data
     */
    public function execute()
    {
        $this->extensionsFeed->getFeed();
        $this->adsFeed->getFeed();
    }
}
