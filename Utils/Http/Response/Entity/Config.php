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

namespace Aimsinfosoft\Base\Utils\Http\Response\Entity;

use Magento\Framework\DataObject;

class Config extends DataObject
{
    public const CLASS_NAME = 'class_name';
    public const TYPE = 'type';
    public const DATA_PROCESSOR = 'data_processor';

    public function getClassName(): string
    {
        return $this->getData(self::CLASS_NAME);
    }

    public function getType(): ?string
    {
        return $this->getData(self::TYPE);
    }

    public function getDataProcessor(): ?DataProcessorInterface
    {
        return $this->getData(self::DATA_PROCESSOR);
    }
}
