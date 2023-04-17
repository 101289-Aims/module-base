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

use Aimsinfosoft\Base\Model\SysInfo\Command\LicenceService\SendSysInfo as CommandSendSysInfo;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SendSysInfo extends Command
{
    /**
     * @var CommandSendSysInfo
     */
    private $sendSysInfo;

    public function __construct(
        CommandSendSysInfo $sendSysInfo,
        string $name = null
    ) {
        parent::__construct($name);
        $this->sendSysInfo = $sendSysInfo;
    }

    protected function configure()
    {
        $this->setName('Aimsinfosoft-base:licence:send-sys-info');
        parent::configure();
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->sendSysInfo->execute();
    }
}
