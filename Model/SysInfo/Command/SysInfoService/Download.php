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

namespace Aimsinfosoft\Base\Model\SysInfo\Command\SysInfoService;

use Aimsinfosoft\Base\Model\SysInfo\Formatter\Xml;
use Aimsinfosoft\Base\Model\SysInfo\Formatter\XmlFactory;
use Aimsinfosoft\Base\Model\SysInfo\Provider\Collector;
use Aimsinfosoft\Base\Model\SysInfo\Provider\CollectorPool;
use Magento\Framework\Exception\NotFoundException;

class Download
{
    /**
     * @var Collector
     */
    private $collector;

    /**
     * @var XmlFactory
     */
    private $xmlFactory;

    public function __construct(Collector $collector, XmlFactory $xmlFactory)
    {
        $this->collector = $collector;
        $this->xmlFactory = $xmlFactory;
    }

    /**
     * @return Xml
     * @throws NotFoundException
     */
    public function execute()
    {
        $data = $this->collector->collect(CollectorPool::SYS_INFO_SERVICE_GROUP);

        return $this->xmlFactory->create(['data' => $data, 'rootNodeName' => 'info']);
    }
}
