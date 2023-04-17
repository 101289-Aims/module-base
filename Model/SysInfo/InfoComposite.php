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

class InfoComposite implements InfoProviderInterface
{
    /**
     * @var InfoProviderInterface[]
     */
    private $providers;

    public function __construct(
        array $providers = []
    ) {
        $this->providers = $providers;
    }

    public function generate(): array
    {
        $info = [];

        foreach ($this->providers as $providerName => $provider) {
            if ($provider instanceof InfoProviderInterface) {
                $info[$providerName] = $provider->generate();
            } else {
                throw new \InvalidArgumentException(
                    __('Object must be an instance of %1', InfoProviderInterface::class)->render()
                );
            }
        }

        return $info;
    }
}
