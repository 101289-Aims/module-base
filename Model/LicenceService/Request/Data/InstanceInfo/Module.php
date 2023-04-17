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

class Module extends SimpleDataObject
{
    public const STATUS = 'status';
    public const CODE = 'code';
    public const VERSION = 'version';

    /**
     * @param bool $status
     * @return $this
     */
    public function setStatus(bool $status): self
    {
        return $this->setData(self::STATUS, $status);
    }

    /**
     * @return bool
     */
    public function getStatus(): bool
    {
        return $this->getData(self::STATUS);
    }

    /**
     * @param string $code
     * @return $this
     */
    public function setCode(string $code): self
    {
        return $this->setData(self::CODE, $code);
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->getData(self::CODE);
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
