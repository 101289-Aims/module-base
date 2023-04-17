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

namespace Aimsinfosoft\Base\Model\LicenceService\Request\Data\InstanceInfo;

use Aimsinfosoft\Base\Model\SimpleDataObject;
use Magento\Framework\Api\ExtensibleDataInterface;

class Platform extends SimpleDataObject implements ExtensibleDataInterface
{
    public const NAME = 'name';
    public const VERSION = 'version';

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name): self
    {
        return $this->setData(self::NAME, $name);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->getData(self::NAME);
    }

    /**
     * @param string $version
     * @return $this
     */
    public function setVersion(string $version): self
    {
        return $this->setData(self::VERSION, $version);
    }

    /**
     * @return string
     */
    public function getVersion(): string
    {
        return $this->getData(self::VERSION);
    }
}
