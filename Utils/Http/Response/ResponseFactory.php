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

namespace Aimsinfosoft\Base\Utils\Http\Response;

use Aimsinfosoft\Base\Model\SimpleDataObject;
use Aimsinfosoft\Base\Model\SimpleDataObjectFactory;
use Aimsinfosoft\Base\Utils\DataConverter;
use Aimsinfosoft\Base\Utils\Http\Response\Entity\ConfigPool;
use Aimsinfosoft\Base\Utils\Http\Response\Entity\Converter;
use Magento\Framework\Exception\NotFoundException;

class ResponseFactory
{
    /**
     * @var Converter
     */
    private $converter;

    /**
     * @var ConfigPool
     */
    private $configPool;

    /**
     * @var SimpleDataObjectFactory
     */
    private $simpleDataObjectFactory;

    /**
     * @var DataConverter
     */
    private $dataConverter;

    public function __construct(
        Converter $converter,
        ConfigPool $configPool,
        SimpleDataObjectFactory $simpleDataObjectFactory,
        DataConverter $dataConverter
    ) {
        $this->converter = $converter;
        $this->configPool = $configPool;
        $this->simpleDataObjectFactory = $simpleDataObjectFactory;
        $this->dataConverter = $dataConverter;
    }

    public function create(string $url, array $response): SimpleDataObject
    {
        $response = $this->dataConverter->convertArrayToSnakeCase($response);
        try {
            // phpcs:disable Magento2.Functions.DiscouragedFunction.Discouraged
            $path = parse_url($url, PHP_URL_PATH);
            $entityConfig = $this->configPool->get($path);
            if ($entityConfig->getType() == 'array') {
                $object = [];
                foreach ($response as $row) {
                    $object[] = $this->converter->convertToObject($row, $entityConfig);
                }
            } else {
                $object = $this->converter->convertToObject($response, $entityConfig);
            }
        } catch (NotFoundException $e) {
            $object = $this->simpleDataObjectFactory->create(['data' => $response ?? []]);
        }

        return $object;
    }
}
