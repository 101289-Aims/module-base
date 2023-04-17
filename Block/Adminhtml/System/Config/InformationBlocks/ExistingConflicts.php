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

namespace Aimsinfosoft\Base\Block\Adminhtml\System\Config\InformationBlocks;

use Aimsinfosoft\Base\Model\Feed\ExtensionsProvider;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Framework\Module\Manager;
use Magento\Framework\View\Element\Template;

class ExistingConflicts extends Template
{
    /**
     * @var string
     */
    protected $_template = 'Aimsinfosoft_Base::config/information/existing_conflicts.phtml';

    /**
     * @var Manager
     */
    private $moduleManager;

    /**
     * @var ExtensionsProvider
     */
    private $extensionsProvider;

    public function __construct(
        Template\Context $context,
        Manager $moduleManager,
        ExtensionsProvider $extensionsProvider,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->moduleManager = $moduleManager;
        $this->extensionsProvider = $extensionsProvider;
    }

    public function getElement(): AbstractElement
    {
        return $this->getParentBlock()->getElement();
    }

    public function getConflictsMessages(): array
    {
        $messages = [];

        foreach ($this->getExistingConflicts() as $moduleName) {
            if ($this->moduleManager->isEnabled($moduleName)) {
                $messages[] = __(
                    'Incompatibility with the %1. '
                    . 'To avoid the conflicts we strongly recommend turning off '
                    . 'the 3rd party mod via the following command: "%2"',
                    $moduleName,
                    'magento module:disable ' . $moduleName
                );
            }
        }

        return $messages;
    }

    private function getExistingConflicts(): array
    {
        $conflicts = [];
        $moduleCode = $this->getElement()->getDataByPath('group/module_code');
        $module = $this->extensionsProvider->getFeedModuleData($moduleCode);
        if ($module && isset($module['conflictExtensions'])) {
            array_map(function ($extension) use (&$conflicts) {
                $conflicts[] = trim($extension);
            }, explode(',', $module['conflictExtensions']));
        }

        return $conflicts;
    }
}
