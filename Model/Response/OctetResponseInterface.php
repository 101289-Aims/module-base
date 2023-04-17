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


namespace Aimsinfosoft\Base\Model\Response;

use Magento\Framework\App;
use Magento\Framework\Filesystem\File\ReadInterface;

interface OctetResponseInterface extends App\Response\HttpInterface, App\PageCache\NotCacheableInterface
{
    public const FILE = 'file';
    public const FILE_URL = 'url';

    public function sendOctetResponse();

    public function getContentDisposition(): string;

    public function getReadResourceByPath(string $readResourcePath): ReadInterface;

    public function setReadResource(ReadInterface $readResource): OctetResponseInterface;

    public function getFileName(): ?string;

    public function setFileName(string $fileName): OctetResponseInterface;
}
