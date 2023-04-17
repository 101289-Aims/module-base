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

namespace Aimsinfosoft\Base\Model\SysInfo\Command\LicenceService\RegisterLicenceKey\Domain;

use Aimsinfosoft\Base\Model\SysInfo\RegisteredInstanceRepository;
use Magento\Framework\UrlInterface;

class Provider
{
    /**
     * @var RegisteredInstanceRepository
     */
    private $registeredInstanceRepository;

    /**
     * @var UrlInterface
     */
    private $url;

    public function __construct(
        RegisteredInstanceRepository $registeredInstanceRepository,
        UrlInterface $url
    ) {
        $this->registeredInstanceRepository = $registeredInstanceRepository;
        $this->url = $url;
    }

    public function getStoredDomains(): array
    {
        $domains = [];
        $registeredInstance = $this->registeredInstanceRepository->get();
        if ($registeredInstance->getInstances()) {
            foreach ($registeredInstance->getInstances() as $instance) {
                $domains[] = $instance->getDomain();
            }
        }

        return $domains;
    }

    public function getCurrentDomains(): array
    {
        // phpcs:disable Magento2.Functions.DiscouragedFunction.Discouraged
        $baseUrl = parse_url($this->url->getBaseUrl(), PHP_URL_HOST);

        return [$baseUrl];
    }
}
