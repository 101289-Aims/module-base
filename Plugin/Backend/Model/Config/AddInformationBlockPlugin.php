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

namespace Aimsinfosoft\Base\Plugin\Backend\Model\Config;

use Aimsinfosoft\Base\Block\Adminhtml\System\Config\Information;
use Magento\Config\Model\Config\ScopeDefiner;
use Magento\Config\Model\Config\Structure;
use Magento\Config\Model\Config\StructureElementInterface;

class AddInformationBlockPlugin
{
    /**
     * @var ScopeDefiner
     */
    private $scopeDefiner;

    public function __construct(
        ScopeDefiner $scopeDefiner
    ) {
        $this->scopeDefiner = $scopeDefiner;
    }

    public function afterGetElementByPathParts(
        Structure $subject,
        StructureElementInterface $result
    ): StructureElementInterface {
        $moduleSection = $result->getData();

        if (!isset($moduleSection['tab'])
            || $moduleSection['tab'] !== StructurePlugin::Aimsinfosoft_TAB_NAME
            || !isset($moduleSection['resource'])
        ) {
            return $result;
        }
        $moduleChildes = &$moduleSection['children'];
        if (isset($moduleChildes['Aimsinfosoft_information'])) {
            return $result; //backward compatibility
        }
        $moduleCode = strtok($moduleSection['resource'], '::');
        $moduleChildes =
            [
                'Aimsinfosoft_information' => [
                    'id' => 'Aimsinfosoft_information',
                    'translate' => 'label',
                    'type' => 'text',
                    'sortOrder' => '1',
                    'showInDefault' => '1',
                    'showInWebsite' => '1',
                    'showInStore' => '1',
                    'label' => 'Information',
                    'frontend_model' => Information::class,
                    '_elementType' => 'group',
                    'path' => $moduleSection['id'] ?? '',
                    'module_code' => $moduleCode
                ]
            ] + $moduleChildes;
        $result->setData($moduleSection, $this->scopeDefiner->getScope());

        return $result;
    }
}
