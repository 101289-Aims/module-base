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

namespace Aimsinfosoft\Base\Model\SysInfo\Command\LicenceService\SendSysInfo;

use Aimsinfosoft\Base\Model\FlagRepository;

class CacheStorage
{
    public const PREFIX = 'Aimsinfosoft_base_';

    /**
     * @var FlagRepository
     */
    private $flagRepository;

    public function __construct(FlagRepository $flagRepository)
    {
        $this->flagRepository = $flagRepository;
    }

    public function get(string $identifier): ?string
    {
        return $this->flagRepository->get(self::PREFIX . $identifier);
    }

    public function set(string $identifier, string $value): bool
    {
        $this->flagRepository->save(self::PREFIX . $identifier, $value);

        return true;
    }
}
