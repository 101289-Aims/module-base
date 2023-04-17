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

use Aimsinfosoft\Base\Model\Feed\NewsProcessor;
use Magento\Backend\Model\Auth\Session;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Psr\Log\LoggerInterface;

class PreDispatchAdminActionController implements ObserverInterface
{
    /**
     * @var Session
     */
    private $backendSession;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var NewsProcessor
     */
    private $newsProcessor;

    public function __construct(
        NewsProcessor $newsProcessor,
        Session $backendAuthSession,
        LoggerInterface $logger
    ) {
        $this->backendSession = $backendAuthSession;
        $this->logger = $logger;
        $this->newsProcessor = $newsProcessor;
    }

    /**
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        if ($this->backendSession->isLoggedIn()) {
            try {
                $this->newsProcessor->checkUpdate();
                $this->newsProcessor->removeExpiredItems();
            } catch (\Exception $exception) {
                $this->logger->critical($exception);
            }
        }
    }
}
