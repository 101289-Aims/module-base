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

class Domain extends SimpleDataObject
{
    public const URL = 'url';

    /**
     * @param string $url
     * @return $this
     */
    public function setUrl(string $url): self
    {
        return $this->setData(self::URL, $url);
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->getData(self::URL);
    }
}
