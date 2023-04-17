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


namespace Aimsinfosoft\Base\Plugin\Backend\Model\Menu;

use Aimsinfosoft\Base\Model\Feed\ExtensionsProvider;
use Aimsinfosoft\Base\Model\ModuleInfoProvider;
use Magento\Backend\Model\Menu\Item as NativeItem;

class Item
{
    public const BASE_MARKETPLACE = 'Aimsinfosoft_Base::marketplace';

    public const SEO_PARAMS = '?utm_source=extension&utm_medium=backend&utm_campaign=main_menu_to_user_guide';

    public const MARKET_URL = 'https://store.aimsinfosoft.com/index.php/magento2-extensions.html'
    . '?utm_source=extension&utm_medium=backend&utm_campaign=main_menu_to_catalog';

    public const MAGENTO_MARKET_URL = 'https://marketplace.magento.com/partner/Aimsinfosoft';

    /**
     * @var ExtensionsProvider
     */
    private $extensionsProvider;

    /**
     * @var ModuleInfoProvider
     */
    private $moduleInfoProvider;

    public function __construct(
        ExtensionsProvider $extensionsProvider,
        ModuleInfoProvider $moduleInfoProvider
    ) {
        $this->extensionsProvider = $extensionsProvider;
        $this->moduleInfoProvider = $moduleInfoProvider;
    }

    /**
     * @param NativeItem $subject
     * @param $url
     *
     * @return string
     */
    public function afterGetUrl(NativeItem $subject, $url)
    {
        $id = $subject->getId();
        if ($id === self::BASE_MARKETPLACE) {
            $url = $this->moduleInfoProvider->isOriginMarketplace() ? self::MAGENTO_MARKET_URL : self::MARKET_URL;
        }

        /* we can't add guide link into item object - find link again */
        if (strpos($id, '::menuguide') !== false
            && strpos($id, 'Aimsinfosoft') !== false
        ) {
            $moduleCode = explode('::', $subject->getId());
            $moduleCode = $moduleCode[0];
            $moduleInfo = $this->extensionsProvider->getFeedModuleData($moduleCode);
            if (isset($moduleInfo['guide']) && $moduleInfo['guide']) {
                $url = $moduleInfo['guide'];
                $seoLink = self::SEO_PARAMS;
                if (strpos($url, '?') !== false) {
                    $seoLink = str_replace('?', '&', $seoLink);
                }
                $url .= $seoLink;
            } else {
                $url = '';
            }
        }

        return $url;
    }
}
