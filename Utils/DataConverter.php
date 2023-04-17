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

namespace Aimsinfosoft\Base\Utils;

use Magento\Framework\Api\SimpleDataObjectConverter;

class DataConverter
{
    /**
     * Converts associative array's key names from camelCase to snake_case, recursively.
     *
     * @param array $properties
     * @return array
     */
    public function convertArrayToSnakeCase(array $properties): array
    {
        foreach ($properties as $name => $value) {
            $snakeCaseName = SimpleDataObjectConverter::camelCaseToSnakeCase($name);
            if (is_array($value)) {
                $value = $this->convertArrayToSnakeCase($value);
            }
            unset($properties[$name]);
            $properties[$snakeCaseName] = $value;
        }

        return $properties;
    }
}
