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
use Aimsinfosoft\Base\Model\SysInfo\Command\LicenceService\RegisterLicenceKey\Converter;
use Aimsinfosoft\Base\Model\SysInfo\Command\LicenceService\RegisterLicenceKey\Domain\Provider;
use Aimsinfosoft\Base\Model\SysInfo\Data\RegisteredInstance\Instance;
use Aimsinfosoft\Base\Model\SysInfo\RegisteredInstanceRepository;
use Magento\Framework\Exception\LocalizedException;

class RegisterLicenceKey
{
    /**
     * @var RegisteredInstanceRepository
     */
    private $registeredInstanceRepository;

    /**
     * @var RequestManager
     */
    private $requestManager;

    /**
     * @var Provider
     */
    private $domainProvider;

    /**
     * @var Converter
     */
    private $converter;

    public function __construct(
        RegisteredInstanceRepository $registeredInstanceRepository,
        RequestManager $requestManager,
        Provider $domainProvider,
        Converter $converter
    ) {
        $this->registeredInstanceRepository = $registeredInstanceRepository;
        $this->requestManager = $requestManager;
        $this->domainProvider = $domainProvider;
        $this->converter = $converter;
    }

    /**
     * @return void
     * @throws LocalizedException
     */
    public function execute(): void
    {
        $currentDomains = $this->domainProvider->getCurrentDomains();
        $storedDomains = $this->domainProvider->getStoredDomains();
        $domains = array_diff($currentDomains, $storedDomains);
        if (!$domains) {
            return;
        }

        $instance = null;
        $instances = [];
        $registrationCompleted = true;
        try {
            foreach ($domains as $domain) {
                $registeredInstanceResponse = $this->requestManager->registerInstance($domain);
                $instanceArray = [
                    Instance::DOMAIN => $domain,
                    Instance::SYSTEM_INSTANCE_KEY => $registeredInstanceResponse->getSystemInstanceKey()
                ];
                $instance = $this->converter->convertArrayToInstance($instanceArray);
                $instances[] = $instance;
            }
        } catch (LocalizedException $exception) {
            $registrationCompleted = false;
        }

        $registeredInstance = $this->registeredInstanceRepository->get();
        $registeredInstance
            ->setCurrentInstance($instance ?? $registeredInstance->getCurrentInstance())
            ->setInstances(array_merge($registeredInstance->getInstances(), $instances));
        $this->registeredInstanceRepository->save($registeredInstance);

        if (!$registrationCompleted) {
            throw new LocalizedException(__('Registration failed, please try again later.'));
        }
    }
}
