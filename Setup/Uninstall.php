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

namespace Aimsinfosoft\Base\Setup;

use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UninstallInterface;

class Uninstall implements UninstallInterface
{
    public function uninstall(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $this
            ->uninstallColumns($setup)
            ->uninstallConfigData($setup);
    }

    private function uninstallColumns(SchemaSetupInterface $setup): self
    {
        $connection = $setup->getConnection();
        $connection->dropColumn(
            $setup->getTable('adminnotification_inbox'),
            'is_Aimsinfosoft'
        );
        $connection->dropColumn(
            $setup->getTable('adminnotification_inbox'),
            'expiration_date'
        );
        $connection->dropColumn(
            $setup->getTable('adminnotification_inbox'),
            'image_url'
        );

        return $this;
    }

    private function uninstallConfigData(SchemaSetupInterface $setup): self
    {
        $configTable = $setup->getTable('core_config_data');
        $setup->getConnection()->delete($configTable, "`path` LIKE 'Aimsinfosoft_base%'");

        return $this;
    }
}
