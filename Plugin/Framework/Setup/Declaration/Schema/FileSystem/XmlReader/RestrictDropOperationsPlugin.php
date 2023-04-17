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

namespace Aimsinfosoft\Base\Plugin\Framework\Setup\Declaration\Schema\FileSystem\XmlReader;

use Magento\Framework\Config\FileIterator;
use Magento\Framework\Config\FileResolverByModule;
use Aimsinfosoft\Base\Model\SysInfo\Provider\Module\Dir\Reader;

/**
 * Fix an issue - when a module is disabled, db_schema.xml of the module is not collecting.
 * But db_schema_whitelist.json is readable even if the module disabled.
 * It cause the issue - DB Tables, Columns, Reference drops while module is disabled.
 * We add the db_schema.xml file of disabled modules to the list as if they were enabled.
 */
class RestrictDropOperationsPlugin
{
    /**
     * @var Reader
     */
    private $moduleReader;

    public function __construct(
        Reader $moduleReader
    ) {
        $this->moduleReader = $moduleReader;
    }

    /**
     * @param FileResolverByModule $subject
     * @param array $result
     * @param string $filename
     * @param string $scope
     * @return array
     */
    public function afterGet(FileResolverByModule $subject, array $result, $filename, $scope): array
    {
        if ($filename == 'db_schema.xml'
            && $scope == FileResolverByModule::ALL_MODULES
        ) {
            $AimsinfosoftDisabledModules = $this->moduleReader->getConfigurationFiles($filename, 'Aimsinfosoft', false)->toArray();
            $allModulesIterator = $this->moduleReader->getConfigurationFiles($filename);

            $sortedResult = $this->buildSorted(
                $allModulesIterator,
                [$result, $AimsinfosoftDisabledModules]
            );
            $diff = array_diff($result, $sortedResult);
            $result = array_merge($sortedResult, $diff);
        }

        return $result;
    }

    private function buildSorted(FileIterator $allModules, array $arraysToMerge): array
    {
        $sortedResult = [];
        $allModules->rewind();
        do {
            $current = $allModules->key();
            foreach ($arraysToMerge as $array) {
                if (isset($array[$current])) {
                    $sortedResult[$current] = $array[$current];
                }
            }
            $allModules->next();
        } while ($allModules->valid());

        return $sortedResult;
    }
}
