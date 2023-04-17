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

use Aimsinfosoft\Base\Model\LicenceService\Request\Data\InstanceInfo\Domain as RequestDomain;
use Aimsinfosoft\Base\Model\SysInfo\Provider\Collector\CollectorInterface;
use Magento\Config\Model\ResourceModel\Config\Data\CollectionFactory as ConfigCollectionFactory;

class Domain implements CollectorInterface
{
    public const CONFIG_PATH_KEY = 'path';
    public const CONFIG_VALUE_KEY = 'value';

    /**
     * @var ConfigCollectionFactory
     */
    private $configCollectionFactory;

    public function __construct(
        ConfigCollectionFactory $configCollectionFactory
    ) {
        $this->configCollectionFactory = $configCollectionFactory;
    }

    public function get(): array
    {
        $configCollection = $this->configCollectionFactory->create()
            ->addFieldToSelect([self::CONFIG_PATH_KEY, self::CONFIG_VALUE_KEY])
            ->addFieldToFilter(self::CONFIG_PATH_KEY, ['like' => '%/base_url']);

        $domains = [];
        foreach ($configCollection->getData() as $config) {
            $domains[][RequestDomain::URL] = $config[self::CONFIG_VALUE_KEY];
        }

        return $domains;
    }
}
