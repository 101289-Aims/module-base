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

namespace Aimsinfosoft\Base\Model\LicenceService\Api;

use Aimsinfosoft\Base\Model\LicenceService\Request\Data\InstanceInfo;
use Aimsinfosoft\Base\Model\LicenceService\Request\Url\Builder;
use Aimsinfosoft\Base\Model\LicenceService\Response\Data\RegisteredInstance;
use Aimsinfosoft\Base\Utils\Http\Curl;
use Aimsinfosoft\Base\Utils\Http\CurlFactory;
use Magento\Framework\Api\SimpleDataObjectConverter;
use Magento\Framework\Exception\LocalizedException;

class RequestManager
{
    /**
     * @var SimpleDataObjectConverter
     */
    private $simpleDataObjectConverter;

    /**
     * @var CurlFactory
     */
    private $curlFactory;

    /**
     * @var Builder
     */
    private $urlBuilder;

    public function __construct(
        SimpleDataObjectConverter $simpleDataObjectConverter,
        CurlFactory $curlFactory,
        Builder $urlBuilder
    ) {
        $this->simpleDataObjectConverter = $simpleDataObjectConverter;
        $this->curlFactory = $curlFactory;
        $this->urlBuilder = $urlBuilder;
    }

    /**
     * @param string $domain
     * @return RegisteredInstance
     * @throws LocalizedException
     */
    public function registerInstance(string $domain): RegisteredInstance
    {
        /** @var Curl $curl */
        $curl = $this->curlFactory->create();
        $url = $this->urlBuilder->build('/api/v1/instance/registration');
        $postParams = json_encode(['domain' => $domain]);

        return $curl->request($url, $postParams);
    }

    /**
     * @param InstanceInfo $instanceInfo
     * @return void
     * @throws LocalizedException
     */
    public function updateInstanceInfo(InstanceInfo $instanceInfo): void
    {
        /** @var Curl $curl */
        $curl = $this->curlFactory->create();
        $url = $this->urlBuilder->build(
            '/api/v1/instance_client/'. $instanceInfo->getSystemInstanceKey() . '/collect'
        );
        $postParams = $this->simpleDataObjectConverter->convertKeysToCamelCase($instanceInfo->toArray());
        $postParams = json_encode($postParams);

        $curl->request($url, $postParams);
    }

    /**
     * @param string $systemInstanceKey
     * @return void
     * @throws LocalizedException
     */
    public function ping(string $systemInstanceKey): void
    {
        /** @var Curl $curl */
        $curl = $this->curlFactory->create();
        $url = $this->urlBuilder->build('/api/v1/instance_client/'. $systemInstanceKey . '/ping');

        $curl->request($url);
    }
}
