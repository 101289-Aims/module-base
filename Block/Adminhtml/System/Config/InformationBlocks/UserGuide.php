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
use Aimsinfosoft\Base\Model\Feed\ExtensionsProvider;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Framework\View\Element\Template;

class UserGuide extends Template
{
    public const USER_GUIDE_PARAM = 'userguide_';

    /**
     * @var string
     */
    protected $_template = 'Aimsinfosoft_Base::config/information/user_guide.phtml';

    /**
     * @var ExtensionsProvider
     */
    private $extensionsProvider;

    public function __construct(
        Template\Context $context,
        ExtensionsProvider $extensionsProvider,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->extensionsProvider = $extensionsProvider;
    }

    public function getUserGuideLink(): string
    {
        $moduleCode = $this->getElement()->getDataByPath('group/module_code');

        $link = $this->extensionsProvider->getFeedModuleData($moduleCode)['guide'] ?? '';
        if ($link) {
            $seoLink = str_replace('?', '&', Information::SEO_PARAMS);
            $link .= $seoLink . self::USER_GUIDE_PARAM . $moduleCode;
        }

        return $link;
    }

    public function getElement(): AbstractElement
    {
        return $this->getParentBlock()->getElement();
    }
}
