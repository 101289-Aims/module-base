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

use Magento\Framework\DB\AggregatedFieldDataConverter;

class SerializedFieldDataConverter
{
    /**
     * @var \Magento\Framework\ObjectManagerInterface
     */
    private $objectManager;

    /**
     * @var \Magento\Framework\App\ResourceConnection
     */
    private $connectionResource;

    public function __construct(
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Magento\Framework\App\ResourceConnection $connectionResource
    ) {
        $this->objectManager = $objectManager;
        $this->connectionResource = $connectionResource;
    }

    /**
     * Convert metadata from serialized to JSON format:
     *
     * @param string|string[] $tableName
     * @param string          $identifierField
     * @param string|string[] $fields
     * @return void
     */
    public function convertSerializedDataToJson($tableName, $identifierField, $fields)
    {
        /** @var AggregatedFieldDataConverter $aggregatedFieldConverter */
        $fieldConverter = $this->objectManager->get(AggregatedFieldDataConverter::class);
        $convertData = [];

        if (is_array($fields)) {
            foreach ($fields as $field) {
                $convertData[] = $this->getConvertedData($tableName, $identifierField, $field);
            }
        } else {
            $convertData[] = $this->getConvertedData($tableName, $identifierField, $fields);
        }

        $fieldConverter->convert(
            $convertData,
            $this->connectionResource->getConnection()
        );
    }

    /**
     * @param string|string[] $tableName
     * @param string          $identifierField
     * @param string          $field
     * @return \Magento\Framework\DB\FieldToConvert
     */
    protected function getConvertedData($tableName, $identifierField, $field)
    {
        $instance = new \Magento\Framework\DB\FieldToConvert(
            \Magento\Framework\DB\DataConverter\SerializedToJson::class,
            $this->connectionResource->getTableName($tableName),
            $identifierField,
            $field
        );

        return $instance;
    }
}
