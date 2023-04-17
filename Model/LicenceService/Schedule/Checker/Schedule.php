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

namespace Aimsinfosoft\Base\Model\LicenceService\Schedule\Checker;

use Aimsinfosoft\Base\Model\LicenceService\Schedule\Data\ScheduleConfig;
use Aimsinfosoft\Base\Model\LicenceService\Schedule\Data\ScheduleConfigFactory;
use Aimsinfosoft\Base\Model\LicenceService\Schedule\ScheduleConfigRepository;
use Magento\Framework\Stdlib\DateTime\DateTime;

class Schedule implements SenderCheckerInterface
{
    /**
     * @var DateTime
     */
    private $dateTime;

    /**
     * @var ScheduleConfigFactory
     */
    private $scheduleConfigFactory;

    /**
     * @var ScheduleConfigRepository
     */
    private $scheduleConfigRepository;

    public function __construct(
        DateTime $dateTime,
        ScheduleConfigFactory $scheduleConfigFactory,
        ScheduleConfigRepository $scheduleConfigRepository
    ) {
        $this->dateTime = $dateTime;
        $this->scheduleConfigFactory = $scheduleConfigFactory;
        $this->scheduleConfigRepository = $scheduleConfigRepository;
    }

    public function isNeedToSend(string $flag): bool
    {
        $currentTime = $this->dateTime->gmtTimestamp();
        try {
            $scheduleConfig = $this->scheduleConfigRepository->get($flag);
        } catch (\InvalidArgumentException $exception) {
            $scheduleConfig = $this->scheduleConfigFactory->create();
            $scheduleConfig->addData($this->getScheduleConfig());
            $scheduleConfig->setLastSendDate($currentTime);
            $this->scheduleConfigRepository->save($flag, $scheduleConfig);

            return true;
        }
        $timeIntervals = $scheduleConfig->getTimeIntervals();
        $firstTimeInterval = array_shift($timeIntervals);
        $isNeedToSend = $currentTime > $scheduleConfig->getLastSendDate() + $firstTimeInterval;
        if ($isNeedToSend) {
            $scheduleConfig->setTimeIntervals($timeIntervals);
            $this->scheduleConfigRepository->save($flag, $scheduleConfig);
        }

        return $isNeedToSend;
    }

    public function getScheduleConfig(): array
    {
        return [
            ScheduleConfig::TIME_INTERVALS => [300, 900, 3600, 86400],
            ScheduleConfig::LAST_SEND_DATE => $this->dateTime->gmtTimestamp()
        ];
    }
}
