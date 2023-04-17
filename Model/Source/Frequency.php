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

class Frequency implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @return array
     */
    public function toOptionArray()
    {
        $options = [
            [
                'value' => 2,
                'label' => __('2 days')
            ],
            [
                'value' => 5,
                'label' => __('5 days')
            ],
            [
                'value' => 10,
                'label' => __('10 days')
            ],
            [
                'value' => 15,
                'label' => __('15 days')
            ],
            [
                'value' => 30,
                'label' => __('30 days')
            ]
        ];

        return $options;
    }
}
