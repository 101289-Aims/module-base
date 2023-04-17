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

/**
 * Event observers configuration schema locator
 */
namespace Aimsinfosoft\Base\Model\LessToCss\Config;

class SchemaLocator implements \Magento\Framework\Config\SchemaLocatorInterface
{
    /** @var \Magento\Framework\Config\Dom\UrnResolver */
    protected $urnResolver;

    public function __construct(\Magento\Framework\Config\Dom\UrnResolver $urnResolver)
    {
        $this->urnResolver = $urnResolver;
    }

    /**
     * Get path to merged config schema
     *
     * @return string
     */
    public function getSchema()
    {
        return $this->urnResolver->getRealPath('urn:Aimsinfosoft:module:Aimsinfosoft_Base:etc/less_to_css.xsd');
    }

    /**
     * Get path to pre file validation schema
     *
     * @return string
     */
    public function getPerFileSchema()
    {
        return $this->getSchema();
    }
}
