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


namespace Aimsinfosoft\Base\Plugin\AdminNotification\Block\Grid\Renderer;

use Magento\AdminNotification\Block\Grid\Renderer\Notice as NativeNotice;

class Notice
{
    public function aroundRender(
        NativeNotice $subject,
        \Closure $proceed,
        \Magento\Framework\DataObject $row
    ) {
        $result = $proceed($row);

        $AimsinfosoftLogo = '';
        $AimsinfosoftImage = '';
        if ($row->getData('is_Aimsinfosoft')) {
            if ($row->getData('image_url')) {
                $AimsinfosoftImage = ' style="background: url(' . $row->getData("image_url") . ') no-repeat;"';
            } else {
                $AimsinfosoftLogo = ' Aimsinfosoft-grid-logo';
            }
        }
        $result = '<div class="ambase-grid-message' . $AimsinfosoftLogo . '"' . $AimsinfosoftImage . '>' . $result . '</div>';

        return  $result;
    }
}
