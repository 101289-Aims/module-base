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


namespace Aimsinfosoft\Base\Helper;

use Aimsinfosoft\Base\Model\Feed\ExtensionsProvider;
use Aimsinfosoft\Base\Model\LinkValidator;
use Aimsinfosoft\Base\Model\ModuleInfoProvider;

/**
 * @deprecated Class for backward compatibility. Will be removed someday
 * @see ExtensionsProvider, LinkValidator, ModuleInfoProvider
 */
class Module
{
    /**
     * @var ExtensionsProvider
     */
    private $extensionsProvider;

    /**
     * @var LinkValidator
     */
    private $linkValidator;

    /**
     * @var ModuleInfoProvider
     */
    private $moduleInfoProvider;

    public function __construct(
        ExtensionsProvider $extensionsProvider,
        LinkValidator $linkValidator,
        ModuleInfoProvider $moduleInfoProvider
    ) {
        $this->extensionsProvider = $extensionsProvider;
        $this->linkValidator = $linkValidator;
        $this->moduleInfoProvider = $moduleInfoProvider;
    }

    /**
     * @deprecated since 1.10.2
     * @see \Aimsinfosoft\Base\Model\Feed\ExtensionsProvider::getAllFeedExtensions
     */
    public function getAllExtensions()
    {
        return $this->extensionsProvider->getAllFeedExtensions();
    }

    /**
     * @deprecated since 1.10.2
     * @see \Aimsinfosoft\Base\Model\Feed\ExtensionsProvider::getFeedModuleData()
     */
    public function getFeedModuleData($moduleCode)
    {
        return $this->extensionsProvider->getFeedModuleData($moduleCode);
    }

    /**
     * @deprecated since 1.10.2
     * @see \Aimsinfosoft\Base\Model\ModuleInfoProvider::getRestrictedModules
     */
    public function getRestrictedModules()
    {
        return $this->moduleInfoProvider->getRestrictedModules();
    }

    /**
     * @deprecated since 1.10.2
     * @see \Aimsinfosoft\Base\Model\ModuleInfoProvider::getModuleInfo
     */
    public function getModuleInfo($moduleCode)
    {
        return $this->moduleInfoProvider->getModuleInfo($moduleCode);
    }

    /**
     * @deprecated since 1.10.2
     * @see \Aimsinfosoft\Base\Model\ModuleInfoProvider::isOriginMarketplace
     */
    public function isOriginMarketplace($moduleCode = 'Aimsinfosoft_Base')
    {
        return $this->moduleInfoProvider->isOriginMarketplace($moduleCode);
    }

    /**
     * @deprecated since 1.10.2
     * @see \Aimsinfosoft\Base\Model\LinkValidator::validate
     */
    public function validateLink($link)
    {
        return $this->linkValidator->validate($link);
    }
}
