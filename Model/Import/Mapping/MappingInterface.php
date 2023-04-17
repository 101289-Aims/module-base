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


namespace Aimsinfosoft\Base\Model\Import\Mapping;

/**
 * @since 1.4.6
 */
interface MappingInterface
{
    /**
     * @return array
     */
    public function getValidColumnNames();

    /**
     * @param string $columnName
     *
     * @throws \Aimsinfosoft\Base\Exceptions\MappingColumnDoesntExist
     * @return string|bool
     */
    public function getMappedField($columnName);

    /**
     * @throws \Aimsinfosoft\Base\Exceptions\MasterAttributeCodeDoesntSet
     * @return string
     */
    public function getMasterAttributeCode();
}
