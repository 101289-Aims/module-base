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

use Aimsinfosoft\Base\Model\LicenceService\Schedule\Checker\Schedule;
use Aimsinfosoft\Base\Model\LicenceService\Schedule\ScheduleConfigRepository;
use Aimsinfosoft\Base\Model\SysInfo\Command\LicenceService\RegisterLicenceKey;
use Aimsinfosoft\Base\Model\SysInfo\RegisteredInstanceRepository;
use Magento\Framework\Exception\LocalizedException;

class InstanceRegistration
{
    public const FLAG_KEY = 'Aimsinfosoft_base_instance_registration';

    /**
     * @var Schedule
     */
    private $scheduleChecker;

    /**
     * @var RegisterLicenceKey
     */
    private $registerLicenceKey;

    /**
     * @var ScheduleConfigRepository
     */
    private $scheduleConfigRepository;

    /**
     * @var RegisteredInstanceRepository
     */
    private $registeredInstanceRepository;

    public function __construct(
        Schedule $scheduleChecker,
        RegisterLicenceKey $registerLicenceKey,
        ScheduleConfigRepository $scheduleConfigRepository,
        RegisteredInstanceRepository $registeredInstanceRepository
    ) {
        $this->scheduleChecker = $scheduleChecker;
        $this->registerLicenceKey = $registerLicenceKey;
        $this->scheduleConfigRepository = $scheduleConfigRepository;
        $this->registeredInstanceRepository = $registeredInstanceRepository;
    }

    public function execute()
    {
        $registeredInstance = $this->registeredInstanceRepository->get();
        $systemInstanceKey = $registeredInstance->getCurrentInstance()
            ? $registeredInstance->getCurrentInstance()->getSystemInstanceKey()
            : null;
        if ($systemInstanceKey) {
            return;
        }
        try {
            if ($this->scheduleChecker->isNeedToSend(self::FLAG_KEY)) {
                $this->registerLicenceKey->execute();
            }
        } catch (LocalizedException $exception) {
            $scheduleConfig = $this->scheduleConfigRepository->get(self::FLAG_KEY);
            if (empty($scheduleConfig->getTimeIntervals())) {
                $scheduleConfig->addData($this->scheduleChecker->getScheduleConfig());
                $this->scheduleConfigRepository->save(self::FLAG_KEY, $scheduleConfig);
            }
        }
    }
}
