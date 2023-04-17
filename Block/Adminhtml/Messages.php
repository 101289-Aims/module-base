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

namespace Aimsinfosoft\Base\Block\Adminhtml;

class Messages extends \Magento\Backend\Block\Template
{
    public const Aimsinfosoft_BASE_SECTION_NAME = 'Aimsinfosoft_base';
    /**
     * @var \Aimsinfosoft\Base\Model\AdminNotification\Messages
     */
    private $messageManager;

    /**
     * @var \Magento\Framework\App\Request\Http
     */
    private $request;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Aimsinfosoft\Base\Model\AdminNotification\Messages $messageManager,
        \Magento\Framework\App\Request\Http $request,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->messageManager = $messageManager;
        $this->request = $request;
    }

    /**
     * @return array
     */
    public function getMessages()
    {
        return $this->messageManager->getMessages();
    }

    /**
     * @return string
     */
    public function _toHtml()
    {
        $html  = '';
        if ($this->request->getParam('section') === self::Aimsinfosoft_BASE_SECTION_NAME) {
            $html = parent::_toHtml();
        }

        return $html;
    }
}
