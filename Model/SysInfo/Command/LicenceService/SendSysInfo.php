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

namespace Aimsinfosoft\Base\Model\SysInfo\Command\LicenceService;

use Aimsinfosoft\Base\Model\LicenceService\Api\RequestManager;
use Aimsinfosoft\Base\Model\SysInfo\Command\LicenceService\SendSysInfo\ChangedData\Persistor as ChangedDataPersistor;
use Aimsinfosoft\Base\Model\SysInfo\Command\LicenceService\SendSysInfo\Converter;
use Aimsinfosoft\Base\Model\SysInfo\RegisteredInstanceRepository;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NotFoundException;

class SendSysInfo
{
    /**
     * @var RegisteredInstanceRepository
     */
    private $registeredInstanceRepository;

    /**
     * @var ChangedDataPersistor
     */
    private $changedDataPersistor;

    /**
     * @var Converter
     */
    private $converter;

    /**
     * @var RequestManager
     */
    private $requestManager;

    public function __construct(
        RegisteredInstanceRepository $registeredInstanceRepository,
        ChangedDataPersistor $changedDataPersistor,
        Converter $converter,
        RequestManager $requestManager
    ) {
        $this->registeredInstanceRepository = $registeredInstanceRepository;
        $this->changedDataPersistor = $changedDataPersistor;
        $this->converter = $converter;
        $this->requestManager = $requestManager;
    }

    /**
     * @return void
     * @throws LocalizedException
     * @throws NotFoundException
     */
    public function execute(): void
    {
        $registeredInstance = $this->registeredInstanceRepository->get();
        $systemInstanceKey = $registeredInstance->getCurrentInstance()
            ? $registeredInstance->getCurrentInstance()->getSystemInstanceKey()
            : null;
        if (!$systemInstanceKey) {
            return;
        }

        $changedData = $this->changedDataPersistor->get();
        if ($changedData) {
            $instanceInfo = $this->converter->convertToObject($changedData);
            $instanceInfo->setSystemInstanceKey($systemInstanceKey);
            try {
                $this->requestManager->updateInstanceInfo($instanceInfo);
                $this->changedDataPersistor->save($changedData);
            } catch (LocalizedException $exception) {
                throw $exception;
            }
        } else {
            $this->requestManager->ping($systemInstanceKey);
        }
    }
}
