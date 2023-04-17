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

namespace Aimsinfosoft\Base\Model\LicenceService\Request\Data;

use Aimsinfosoft\Base\Model\LicenceService\Request\Data\InstanceInfo\Platform;
use Aimsinfosoft\Base\Model\SimpleDataObject;
use Magento\Framework\Api\ExtensibleDataInterface;

class InstanceInfo extends SimpleDataObject implements ExtensibleDataInterface
{
    public const SYSTEM_INSTANCE_KEY = 'system_instance_key';
    public const MODULES = 'modules';
    public const DOMAINS = 'domains';
    public const PLATFORM = 'platform';

    /**
     * @param string|null $systemInstanceKey
     * @return $this
     */
    public function setSystemInstanceKey(?string $systemInstanceKey): self
    {
        return $this->setData(self::SYSTEM_INSTANCE_KEY, $systemInstanceKey);
    }

    /**
     * @return string|null
     */
    public function getSystemInstanceKey(): ?string
    {
        return $this->getData(self::SYSTEM_INSTANCE_KEY);
    }

    /**
     * @param \Aimsinfosoft\Base\Model\LicenceService\Request\Data\InstanceInfo\Module[]|null $modules
     * @return $this
     */
    public function setModules(array $modules): self
    {
        return $this->setData(self::MODULES, $modules);
    }

    /**
     * @return \Aimsinfosoft\Base\Model\LicenceService\Request\Data\InstanceInfo\Module[]|null
     */
    public function getModules(): ?array
    {
        return $this->getData(self::MODULES);
    }

    /**
     * @param \Aimsinfosoft\Base\Model\LicenceService\Request\Data\InstanceInfo\Domain[]|null $domains
     * @return $this
     */
    public function setDomains(array $domains): self
    {
        return $this->setData(self::DOMAINS, $domains);
    }

    /**
     * @return \Aimsinfosoft\Base\Model\LicenceService\Request\Data\InstanceInfo\Domain[]|null
     */
    public function getDomains(): ?array
    {
        return $this->getData(self::DOMAINS);
    }

    /**
     * @param \Aimsinfosoft\Base\Model\LicenceService\Request\Data\InstanceInfo\Platform $platform
     * @return $this
     */
    public function setPlatform(Platform $platform): self
    {
        return $this->setData(self::PLATFORM, $platform);
    }

    /**
     * @return \Aimsinfosoft\Base\Model\LicenceService\Request\Data\InstanceInfo\Platform
     */
    public function getPlatform(): Platform
    {
        return $this->getData(self::PLATFORM);
    }
}
