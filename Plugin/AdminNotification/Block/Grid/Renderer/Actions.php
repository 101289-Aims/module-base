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

use Magento\AdminNotification\Block\Grid\Renderer\Actions as NativeActions;

class Actions
{
    /**
     * @var \Magento\Framework\UrlInterface
     */
    private $urlBuilder;

    public function __construct(
        \Magento\Framework\UrlInterface $urlBuilder
    ) {
        $this->urlBuilder = $urlBuilder;
    }

    /**
     * @param NativeActions $subject
     * @param \Closure $proceed
     * @param \Magento\Framework\DataObject $row
     *
     * @return string
     */
    public function aroundRender(
        NativeActions $subject,
        \Closure $proceed,
        \Magento\Framework\DataObject $row
    ) {
        $result = $proceed($row);
        if ($row->getData('is_Aimsinfosoft')) {
            $result .= sprintf(
                '<a class="action" href="%s" title="%2$s">%2$s</a>',
                $this->urlBuilder->getUrl('ambase/notification/frequency', ['action' => 'less']),
                __('Show less of these messages')
            );
            $result .= sprintf(
                '<a class="action" href="%s" title="%2$s">%2$s</a>',
                $this->urlBuilder->getUrl('ambase/notification/frequency', ['action' => 'more']),
                __('Show more of these messages')
            );
            $result .= sprintf(
                '<a class="action" href="%s" title="%2$s">%2$s</a>',
                $this->urlBuilder->getUrl(
                    'adminhtml/system_config/edit',
                    ['section' => 'Aimsinfosoft_base', '_fragment' => 'Aimsinfosoft_base_notifications-head']
                ),
                __('Unsubscribe')
            );
        }

        return  $result;
    }
}
