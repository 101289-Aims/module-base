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

namespace Aimsinfosoft\Base\Model\SysInfo\Provider;

use Aimsinfosoft\Base\Model\SysInfo\InfoProviderInterface;
use Aimsinfosoft\Base\Model\ModuleInfoProvider;
use Magento\Framework\Module\ModuleListInterface;

class Module implements InfoProviderInterface
{
    const MODULE_VERSION_KEY = 'version';

    /**
     * @var ModuleInfoProvider
     */
    private $moduleInfoProvider;

    /**
     * @var ModuleListInterface
     */
    private $moduleList;

    public function __construct(
        ModuleInfoProvider $moduleInfoProvider,
        ModuleListInterface $moduleList
    ) {
        $this->moduleInfoProvider = $moduleInfoProvider;
        $this->moduleList = $moduleList;
    }

    public function generate(): array
    {
        $modulesData = [];
        $moduleNames = $this->moduleList->getNames();

        foreach ($moduleNames as $moduleName) {
            if (strpos($moduleName, 'Magento_') !== false) {
                continue;
            }

            $modulesData[$moduleName] = $this->getModuleData($moduleName);
        }

        return $modulesData;
    }

    protected function getModuleData(string $moduleName): array
    {
        $moduleInfo = $this->moduleInfoProvider->getModuleInfo($moduleName);
        $moduleVersion = $moduleInfo[self::MODULE_VERSION_KEY] ?? '';

        return [self::MODULE_VERSION_KEY => $moduleVersion];
    }
}
