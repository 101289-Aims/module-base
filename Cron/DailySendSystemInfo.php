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

use Aimsinfosoft\Base\Model\SysInfo\Command\LicenceService\SendSysInfo;
use Aimsinfosoft\Base\Model\LicenceService\Schedule\Checker\Daily;

class DailySendSystemInfo
{
    public const FLAG_KEY = 'Aimsinfosoft_base_daily_send_system_info';

    /**
     * @var SendSysInfo
     */
    private $sysInfo;

    /**
     * @var Daily
     */
    private $dailyChecker;

    public function __construct(
        SendSysInfo $sysInfo,
        Daily $dailyChecker
    ) {
        $this->sysInfo = $sysInfo;
        $this->dailyChecker = $dailyChecker;
    }

    public function execute()
    {
        if ($this->dailyChecker->isNeedToSend(self::FLAG_KEY)) {
            $this->sysInfo->execute();
        }
    }
}
