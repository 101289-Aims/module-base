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


namespace Aimsinfosoft\Base\Model\Source;

class NotificationType implements \Magento\Framework\Option\ArrayInterface
{
    public const GENERAL = 'INFO';
    public const SPECIAL_DEALS = 'PROMO';
    public const AVAILABLE_UPDATE = 'INSTALLED_UPDATE';
    public const UNSUBSCRIBE_ALL = 'UNSUBSCRIBE_ALL';
    public const TIPS_TRICKS = 'TIPS_TRICKS';

    public function toOptionArray()
    {
        $types = [
            [
                'value' => self::GENERAL,
                'label' => __('General Info')
            ],
            [
                'value' => self::SPECIAL_DEALS,
                'label' => __('Special Deals')
            ],
            [
                'value' => self::AVAILABLE_UPDATE,
                'label' => __('Available Updates')
            ],
            [
                'value' => self::TIPS_TRICKS,
                'label' => __('Magento Tips & Tricks')
            ],
            [
                'value' => self::UNSUBSCRIBE_ALL,
                'label' => __('Unsubscribe from all')
            ]
        ];

        return $types;
    }
}
