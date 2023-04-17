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

namespace Aimsinfosoft\Base\Console\Command;

use Aimsinfosoft\Base\Model\SysInfo\Command\LicenceService\RegisterLicenceKey as CommandRegisterLicenceKey;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RegisterLicenceKey extends Command
{
    /**
     * @var CommandRegisterLicenceKey
     */
    private $registerLicenceKey;

    public function __construct(
        CommandRegisterLicenceKey $registerLicenceKey,
        string $name = null
    ) {
        parent::__construct($name);
        $this->registerLicenceKey = $registerLicenceKey;
    }

    protected function configure()
    {
        $this->setName('Aimsinfosoft-base:licence:register-key');
        parent::configure();
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->registerLicenceKey->execute();
    }
}
