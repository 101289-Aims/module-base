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

namespace Aimsinfosoft\Base\Model\SysInfo;

use Aimsinfosoft\Base\Model\FlagRepository;
use Aimsinfosoft\Base\Model\SysInfo\Data\RegisteredInstance;
use Aimsinfosoft\Base\Model\SysInfo\Data\RegisteredInstanceFactory;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Serialize\SerializerInterface;

class RegisteredInstanceRepository
{
    public const REGISTERED_INSTANCE = 'Aimsinfosoft_base_registered_instance';

    /**
     * @var FlagRepository
     */
    private $flagRepository;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @var DataObjectHelper
     */
    private $dataObjectHelper;

    /**
     * @var RegisteredInstanceFactory
     */
    private $registeredInstanceFactory;

    public function __construct(
        FlagRepository $flagRepository,
        SerializerInterface $serializer,
        DataObjectHelper $dataObjectHelper,
        RegisteredInstanceFactory $registeredInstanceFactory
    ) {
        $this->flagRepository = $flagRepository;
        $this->serializer = $serializer;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->registeredInstanceFactory = $registeredInstanceFactory;
    }

    public function get(): RegisteredInstance
    {
        $registeredInstance = $this->registeredInstanceFactory->create();
        $regInstSerialized = $this->flagRepository->get(self::REGISTERED_INSTANCE);
        $regInstArray = $regInstSerialized ? $this->serializer->unserialize($regInstSerialized) : [];
        $this->dataObjectHelper->populateWithArray(
            $registeredInstance,
            $regInstArray,
            RegisteredInstance::class
        );

        return $registeredInstance;
    }

    public function save(RegisteredInstance $registeredInstance): bool
    {
        $regInstArray = $registeredInstance->toArray();
        $regInstSerialized = $this->serializer->serialize($regInstArray);
        $this->flagRepository->save(self::REGISTERED_INSTANCE, $regInstSerialized);

        return true;
    }
}
