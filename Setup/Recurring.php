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


namespace Aimsinfosoft\Base\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class Recurring implements \Magento\Framework\Setup\InstallSchemaInterface
{
    const NOTIFICATION_TABLE = 'adminnotification_inbox';
    const IS_Aimsinfosoft_COLUMN = 'is_aimsinfosoft';
    const EXPIRATION_COLUMN = 'expiration_date';
    const IMAGE_URL_COLUMN = 'image_url';

    /**
     * @param SchemaSetupInterface   $setup
     * @param ModuleContextInterface $context
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        if ($setup->getConnection()->isTableExists($setup->getTable(self::NOTIFICATION_TABLE))) {
            if (!$this->notificationTableColumnExist($setup, self::IS_Aimsinfosoft_COLUMN)) {
                $this->addIsAimsinfosoftField($setup);
            }

            if (!$this->notificationTableColumnExist($setup, self::EXPIRATION_COLUMN)) {
                $this->addExpireField($setup);
            }

            if (!$this->notificationTableColumnExist($setup, self::IMAGE_URL_COLUMN)) {
                $this->addImageUrlField($setup);
            }
        }

        $setup->endSetup();
    }

    private function notificationTableColumnExist(SchemaSetupInterface $setup, $column)
    {
        return $setup->getConnection()->tableColumnExists(
            $setup->getTable(self::NOTIFICATION_TABLE),
            $column
        );
    }

    /**
     * @param SchemaSetupInterface $setup
     */
    private function addIsAimsinfosoftField(SchemaSetupInterface $setup)
    {
        $setup->getConnection()->addColumn(
            $setup->getTable(self::NOTIFICATION_TABLE),
            self::IS_Aimsinfosoft_COLUMN,
            [
                'type' => Table::TYPE_SMALLINT,
                'nullable' => false,
                'default' => 0,
                'comment' => 'Is Aimsinfosoft Notification'
            ]
        );
    }

    /**
     * @param SchemaSetupInterface $setup
     */
    private function addExpireField(SchemaSetupInterface $setup)
    {
        $setup->getConnection()->addColumn(
            $setup->getTable(self::NOTIFICATION_TABLE),
            self::EXPIRATION_COLUMN,
            [
                'type' => Table::TYPE_DATETIME,
                'nullable' => true,
                'default' => null,
                'comment' => 'Expiration Date'
            ]
        );
    }

    /**
     * @param SchemaSetupInterface $setup
     */
    private function addImageUrlField(SchemaSetupInterface $setup)
    {
        $setup->getConnection()->addColumn(
            $setup->getTable(self::NOTIFICATION_TABLE),
            self::IMAGE_URL_COLUMN,
            [
                'type' => Table::TYPE_TEXT,
                'nullable' => true,
                'default' => null,
                'comment' => 'Image Url'
            ]
        );
    }
}
