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

namespace Aimsinfosoft\Base\Model;

use Magento\Framework\Flag;
use Magento\Framework\Flag\FlagResource;
use Magento\Framework\FlagFactory;

class FlagRepository
{
    /**
     * @var FlagResource
     */
    private $flagResource;

    /**
     * @var FlagFactory
     */
    private $flagFactory;

    public function __construct(
        FlagResource $flagResource,
        FlagFactory $flagFactory
    ) {
        $this->flagResource = $flagResource;
        $this->flagFactory = $flagFactory;
    }

    public function get(string $code): ?string
    {
        return $this->getFlagObject($code)->getFlagData();
    }

    public function save(string $code, string $value): bool
    {
        $flag = $this->getFlagObject($code);
        $flag->setFlagData($value);
        $this->flagResource->save($flag);

        return true;
    }

    private function getFlagObject(string $code): Flag
    {
        $flagModel = $this->flagFactory->create(['data' => ['flag_code' => $code]]);
        $this->flagResource->load(
            $flagModel,
            $code,
            'flag_code'
        );

        return $flagModel;
    }
}
