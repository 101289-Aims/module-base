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

namespace Aimsinfosoft\Base\Model\SysInfo\Formatter;

use Magento\Framework\Xml\Generator as XmlGenerator;

class Xml implements FormatterInterface
{
    public const FILE_EXTENSION = 'xml';

    /**
     * @var XmlGenerator
     */
    private $xmlGenerator;

    /**
     * @var array
     */
    private $data;

    /**
     * @var string
     */
    private $rootNodeName;

    public function __construct(
        XmlGenerator $xmlGenerator,
        array $data,
        string $rootNodeName
    ) {
        $this->xmlGenerator = $xmlGenerator;
        $this->data = $data;
        $this->rootNodeName = $rootNodeName;
    }

    public function getContent(): string
    {
        $content = $this->xmlGenerator
            ->arrayToXml([$this->rootNodeName => $this->data])
            ->getDom()
            ->saveXML();

        return $content;
    }

    public function getExtension(): string
    {
        return self::FILE_EXTENSION;
    }
}
