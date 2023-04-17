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


namespace Aimsinfosoft\Base\Model\AdminNotification;

class Messages
{
    public const AMBASE_SESSION_IDENTIFIER = 'ambase-session-messages';

    /**
     * @var \Magento\Backend\Model\Session
     */
    private $session;

    public function __construct(
        \Magento\Backend\Model\Session $session
    ) {
        $this->session = $session;
    }

    /**
     * @param string $message
     */
    public function addMessage($message)
    {
        $messages = $this->session->getData(self::AMBASE_SESSION_IDENTIFIER);
        if (!$messages || !is_array($messages)) {
            $messages = [];
        }

        $messages[] = $message;
        $this->session->setData(self::AMBASE_SESSION_IDENTIFIER, $messages);
    }

    /**
     * @return array
     */
    public function getMessages()
    {
        $messages = $this->session->getData(self::AMBASE_SESSION_IDENTIFIER);
        $this->clear();
        if (!$messages || !is_array($messages)) {
            $messages = [];
        }

        return $messages;
    }

    public function clear()
    {
        $this->session->setData(self::AMBASE_SESSION_IDENTIFIER, []);
    }
}
