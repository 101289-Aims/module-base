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

use Aimsinfosoft\Base\Model\ModuleListProcessor;
use Magento\Backend\Block\Template;
use Magento\Config\Block\System\Config\Form\Field;
use Magento\Store\Model\ScopeInterface;
use Aimsinfosoft\Base\Model\Source\NotificationType;
use Aimsinfosoft\Base\Model\Config;

class Notification extends Field
{
    /**
     * @var string
     */
    protected $_template = 'Aimsinfosoft_Base::notification.phtml';

    /**
     * @var ModuleListProcessor
     */
    private $moduleListProcessor;

    /**
     * @var Config
     */
    private $config;

    public function __construct(
        Template\Context $context,
        ModuleListProcessor $moduleListProcessor,
        Config $config,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->moduleListProcessor = $moduleListProcessor;
        $this->config = $config;
    }

    protected function _toHtml()
    {
        if ($this->isSetNotification()) {
            return parent::_toHtml();
        }

        return '';
    }

    /**
     * @return int|null
     * @throws \Magento\Framework\Exception\FileSystemException
     */
    public function getUpdatesCount()
    {
        $modules = $this->moduleListProcessor->getModuleList();

        return count($modules['hasUpdate']);
    }

    /**
     * @return bool
     */
    protected function isSetNotification()
    {
        $value = $this->config->getEnabledNotificationTypes();

        return in_array(NotificationType::AVAILABLE_UPDATE, $value);
    }
}
