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

namespace Aimsinfosoft\Base\Model\SysInfo\Provider\Collector\LicenceService;

use Aimsinfosoft\Base\Model\LicenceService\Request\Data\InstanceInfo\Module as RequestModule;
use Aimsinfosoft\Base\Model\ModuleInfoProvider;
use Aimsinfosoft\Base\Model\SysInfo\Provider\Collector\CollectorInterface;
use Magento\Framework\App\DeploymentConfig;
use Magento\Framework\Config\ConfigOptionsListConstants;

class Module implements CollectorInterface
{
    /**
     * @var ModuleInfoProvider
     */
    private $moduleInfoProvider;

    /**
     * @var DeploymentConfig
     */
    private $deploymentConfig;

    public function __construct(
        ModuleInfoProvider $moduleInfoProvider,
        DeploymentConfig $deploymentConfig
    ) {
        $this->moduleInfoProvider = $moduleInfoProvider;
        $this->deploymentConfig = $deploymentConfig;
    }

    public function get(): array
    {
        $modulesData = [];
        $moduleList = $this->deploymentConfig->get(ConfigOptionsListConstants::KEY_MODULES);
        foreach ($moduleList as $moduleName => $moduleStatus) {
            if (strpos($moduleName, 'Aimsinfosoft_') === 0) {
                $moduleInfo = $this->moduleInfoProvider->getModuleInfo($moduleName);
                $modulesData[] = [
                    RequestModule::CODE => $moduleName,
                    RequestModule::VERSION => $moduleInfo[ModuleInfoProvider::MODULE_VERSION_KEY] ?? '',
                    RequestModule::STATUS  => (bool)$moduleStatus
                ];
            }
        }

        return $modulesData;
    }
}
