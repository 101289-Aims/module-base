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

namespace Aimsinfosoft\Base\Plugin\Framework\Setup\Declaration\Schema\Diff\Diff;

use Magento\Framework\Setup\Declaration\Schema\Diff\Diff;
use Magento\Framework\Setup\Declaration\Schema\Dto\ElementInterface;
use Magento\Framework\Setup\Declaration\Schema\Operations\DropTable;

/**
 * Fix an issue - when a module is disabled, db_schema.xml of the module is not collecting.
 * But db_schema_whitelist.json is readable even if the module disabled.
 * It cause the issue - DB Tables drops while module is disabled.
 */
class RestrictDropTables
{
    /**
     * Restrict to delete Aimsinfosoft tables throw Declarative Schema.
     *
     * @param Diff $subject
     * @param bool $result
     * @param ElementInterface $object
     * @param string $operation
     *
     * @return bool
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterCanBeRegistered(Diff $subject, bool $result, ElementInterface $object, $operation): bool
    {
        if ($result === true
            && $operation === DropTable::OPERATION_NAME
            && stripos($object->getName(), 'Aimsinfosoft') !== false
        ) {
            $result = false;
        }

        return $result;
    }
}
