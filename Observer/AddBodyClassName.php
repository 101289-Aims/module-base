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


namespace Aimsinfosoft\Base\Observer;

use Magento\Framework\Event\ObserverInterface;

/**
 * Class AddBodyClassName
 * frontend area, layout_render_before event
 */
class AddBodyClassName implements ObserverInterface
{
    public const SMARTWAVE_PORTO_CODE = 'Smartwave/porto';

    /**
     * @var \Magento\Framework\View\Page\Config
     */
    private $pageConfig;

    /**
     * @var \Magento\Framework\View\DesignInterface
     */
    private $design;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    public function __construct(
        \Magento\Framework\View\Page\Config $pageConfig,
        \Magento\Framework\View\DesignInterface $design,
        \Psr\Log\LoggerInterface $logger
    ) {
        $this->pageConfig = $pageConfig;
        $this->design = $design;
        $this->logger = $logger;
    }

    /**
     * @param \Magento\Framework\Event\Observer $observer
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        if (strpos($this->design->getDesignTheme()->getCode(), self::SMARTWAVE_PORTO_CODE) !== false) {
            try {
                if ($this->pageConfig->getElementAttribute(
                    \Magento\Framework\View\Page\Config::ELEMENT_TYPE_BODY,
                    \Magento\Framework\View\Page\Config::BODY_ATTRIBUTE_CLASS
                )) {
                    $this->pageConfig->addBodyClass('am-porto-cmtb');
                }
            } catch (\Exception $exception) {
                $this->logger->critical($exception);
            }
        }
    }
}
