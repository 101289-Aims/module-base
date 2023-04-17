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

namespace Aimsinfosoft\Base\Plugin\Setup\Model\DeclarationInstaller;

use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Setup\Declaration\Schema\DryRunLogger;
use Magento\Framework\Setup\Patch\PatchApplier;
use Magento\Framework\Setup\Patch\PatchHistory;
use Magento\Setup\Model\DeclarationInstaller;

class ApplyPatchesBeforeDeclarativeSchema
{
    /**
     * @var PatchApplier
     */
    private $patchApplier;

    /**
     * @var ResourceConnection
     */
    private $resourceConnection;

    /**
     * @var string[]
     */
    private $moduleNames;

    public function __construct(
        PatchApplier $patchApplier,
        ResourceConnection $resourceConnection,
        array $moduleNames = []
    ) {
        $this->patchApplier = $patchApplier;
        $this->resourceConnection = $resourceConnection;
        $this->moduleNames = $moduleNames;
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     *
     * @param DeclarationInstaller $declarationInstaller
     * @param array $request
     * @return array|null
     * @throws \Magento\Framework\Setup\Exception
     */
    public function beforeInstallSchema(
        DeclarationInstaller $declarationInstaller,
        array $request
    ): ?array {
        $isDryRun = $request[DryRunLogger::INPUT_KEY_DRY_RUN_MODE] ?? true;
        $connection = $this->resourceConnection->getConnection();

        if (!$isDryRun
            && $connection->isTableExists($this->resourceConnection->getTableName(PatchHistory::TABLE_NAME))
        ) {
            foreach ($this->moduleNames as $moduleName) {
                $this->patchApplier->applySchemaPatch($moduleName);
            }
        }

        return null;
    }
}
