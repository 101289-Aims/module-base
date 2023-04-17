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

namespace Aimsinfosoft\Base\Block\Adminhtml\System\Config\InformationBlocks;

use Aimsinfosoft\Base\Block\Adminhtml\System\Config\Information;
use Aimsinfosoft\Base\Model\ModuleInfoProvider;
use Magento\Framework\View\Element\Template;

class FeatureRequest extends Template
{
    public const FEATURE_LINK = 'https://www.aimsinfosoft.com/contact-us/';
    public const CAMPAIGN_NAME = 'request_a_feature';

    /**
     * @var string
     */
    protected $_template = 'Aimsinfosoft_Base::config/information/feature_request.phtml';

    /**
     * @var ModuleInfoProvider
     */
    private $moduleInfoProvider;

    public function __construct(
        Template\Context $context,
        ModuleInfoProvider $moduleInfoProvider,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->moduleInfoProvider = $moduleInfoProvider;
    }

    public function getFeatureRequestLink(): string
    {
        return self::FEATURE_LINK . Information::SEO_PARAMS . self::CAMPAIGN_NAME;
    }

    public function isOriginMarketplace(): bool
    {
        return $this->moduleInfoProvider->isOriginMarketplace();
    }
}
