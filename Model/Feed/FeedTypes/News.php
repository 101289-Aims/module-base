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

namespace Aimsinfosoft\Base\Model\Feed\FeedTypes;

use Aimsinfosoft\Base\Model\AdminNotification\Model\ResourceModel\Inbox\Collection\ExistsFactory;
use Aimsinfosoft\Base\Model\Config;
use Aimsinfosoft\Base\Model\Feed\FeedContentProvider;
use Aimsinfosoft\Base\Model\ModuleInfoProvider;
use Aimsinfosoft\Base\Model\Parser;
use Aimsinfosoft\Base\Model\Source\NotificationType;
use Magento\Framework\App\ProductMetadataInterface;
use Magento\Framework\DataObjectFactory;
use Magento\Framework\Escaper;
use Magento\Framework\Module\ModuleListInterface;
use Magento\Framework\Notification\MessageInterface;

class News
{
    /**
     * @var array
     */
    protected $AimsinfosoftModules = [];

    /**
     * @var Config
     */
    private $config;

    /**
     * @var FeedContentProvider
     */
    private $feedContentProvider;

    /**
     * @var Parser
     */
    private $parser;

    /**
     * @var ProductMetadataInterface
     */
    private $productMetadata;

    /**
     * @var ModuleListInterface
     */
    private $moduleList;

    /**
     * @var ExistsFactory
     */
    private $inboxExistsFactory;

    /**
     * @var Escaper
     */
    private $escaper;

    /**
     * @var DataObjectFactory
     */
    private $dataObjectFactory;

    /**
     * @var ModuleInfoProvider
     */
    private $moduleInfoProvider;

    public function __construct(
        Config $config,
        FeedContentProvider $feedContentProvider,
        Parser $parser,
        ProductMetadataInterface $productMetadata,
        ModuleListInterface $moduleList,
        ExistsFactory $inboxExistsFactory,
        Escaper $escaper,
        DataObjectFactory $dataObjectFactory,
        ModuleInfoProvider $moduleInfoProvider
    ) {
        $this->config = $config;
        $this->feedContentProvider = $feedContentProvider;
        $this->parser = $parser;
        $this->productMetadata = $productMetadata;
        $this->moduleList = $moduleList;
        $this->inboxExistsFactory = $inboxExistsFactory;
        $this->escaper = $escaper;
        $this->dataObjectFactory = $dataObjectFactory;
        $this->moduleInfoProvider = $moduleInfoProvider;
    }

    /**
     * @return array
     */
    public function execute(): array
    {
        $feedData = [];
        $allowedNotifications = $this->config->getEnabledNotificationTypes();

        if (empty($allowedNotifications) || in_array(NotificationType::UNSUBSCRIBE_ALL, $allowedNotifications)) {
            return $feedData;
        }

        $maxPriority = 0;

        $feedResponse = $this->feedContentProvider->getFeedResponse(
            $this->feedContentProvider->getFeedUrl(FeedContentProvider::URN_NEWS)
        );

        $feedXml = $this->parser->parseXml($feedResponse->getContent());
         
        if (isset($feedXml->channel->item)) {
            
            $installDate = $this->config->getFirstModuleRun();
            foreach ($feedXml->channel->item as $item) {
                
                if ((int)$item->version === 1 // for magento One
                    || ((string)$item->edition && (string)$item->edition !== $this->getCurrentEdition())
                    || !array_intersect($this->convertToArray($item->type ?? ''), $allowedNotifications)
                ) {
                    continue;
                }
             
                $priority = $item->priority ?? 1;

                if ($priority <= $maxPriority || !$this->isItemValid($item)) {
                    continue;
                }
                $date = strtotime((string)$item->pubDate);
                $expired = isset($item->expirationDate) ? strtotime((string)$item->expirationDate) : null;
                
                //07-03-2023change this condition less than to greater then
                if ($installDate <= $date && (!$expired || $expired > gmdate('U'))) {
                    $maxPriority = $priority;
                    $expired = $expired ? date('Y-m-d H:i:s', $expired) : null;

                    $feedData = [
                        'severity'        => MessageInterface::SEVERITY_NOTICE,
                        'date_added'      => date('Y-m-d H:i:s', $date),
                        'expiration_date' => $expired,
                        'title'           => $this->convertString($item->title),
                        'description'     => $this->convertString($item->description),
                        'url'             => $this->convertString($item->link),
                        'is_Aimsinfosoft'       => 1,
                        'image_url'       => $this->convertString($item->image)
                    ];
                }
            }
        }
        return $feedData;
    }

    /**
     * @param \SimpleXMLElement $item
     *
     * @return bool
     */
    protected function isItemValid(\SimpleXMLElement $item): bool
    {
        return $this->validateByExtension((string)$item->extension)
            && $this->validateByAimsinfosoftCount($item->Aimsinfosoft_module_qty)
            && $this->validateByNotInstalled((string)$item->Aimsinfosoft_module_not)
            && $this->validateByExtension((string)$item->third_party_modules, true)
            && $this->validateByDomainZone((string)$item->domain_zone)
            && !$this->isItemExists($item);
    }

    /**
     * @return string
     */
    protected function getCurrentEdition(): string
    {
        return $this->productMetadata->getEdition() === 'Community' ? 'ce' : 'ee';
    }

    /**
     * @param mixed $value
     *
     * @return array
     */
    private function convertToArray($value): array
    {
        return explode(',', (string)$value);
    }

    /**
     * @param \SimpleXMLElement $data
     *
     * @return string
     */
    private function convertString(\SimpleXMLElement $data): string
    {
        return $this->escaper->escapeHtml((string)$data);
    }

    /**
     * @return string[]
     */
    private function getAllExtensions(): array
    {
        $modules = $this->moduleList->getNames();
        $dispatchResult = $this->dataObjectFactory->create()->setData($modules);

        return $dispatchResult->toArray();
    }

    /**
     * @return string[]
     */
    private function getInstalledAimsinfosoftExtensions(): array
    {
        if (!$this->AimsinfosoftModules) {
            $modules = $this->moduleList->getNames();

            $dispatchResult = new \Magento\Framework\DataObject($modules);
            $modules = $dispatchResult->toArray();

            $modules = array_filter(
                $modules,
                static function ($item) {
                    return strpos($item, 'Aimsinfosoft_') !== false;
                }
            );
            $this->AimsinfosoftModules = $modules;
        }

        return $this->AimsinfosoftModules;
    }

    /**
     * @param string $extensions
     * @param bool $allModules
     *
     * @return bool
     */
    private function validateByExtension(string $extensions, bool $allModules = false): bool
    {
        if ($extensions) {
            $result = false;
            $arrExtensions = $this->getExtensionValue($extensions);

            if ($arrExtensions) {
                $installedModules = $allModules ? $this->getAllExtensions() : $this->getInstalledAimsinfosoftExtensions();
                $intersect = array_intersect($arrExtensions, $installedModules);
                if ($intersect) {
                    $result = true;
                }
            }
        } else {
            $result = true;
        }

        return $result;
    }

    /**
     * @param string $extensions
     *
     * @return bool
     */
    private function validateByNotInstalled(string $extensions): bool
    {
        if ($extensions) {
            $result = false;
            $arrExtensions = $this->getExtensionValue($extensions);

            if ($arrExtensions) {
                $installedModules = $this->getInstalledAimsinfosoftExtensions();
                $diff = array_diff($arrExtensions, $installedModules);
                if ($diff) {
                    $result = true;
                }
            }
        } else {
            $result = true;
        }

        return $result;
    }

    /**
     * @param string $extensions
     *
     * @return array
     */
    private function getExtensionValue(string $extensions): array
    {
        $arrExtensions = explode(',', $extensions);
        $arrExtensions = array_filter(
            $arrExtensions,
            static function ($item) {
                return strpos($item, '_1') === false;
            }
        );

        $arrExtensions = array_map(
            static function ($item) {
                return str_replace('_2', '', $item);
            },
            $arrExtensions
        );

        return $arrExtensions;
    }

    /**
     * @param int|string $counts
     *
     * @return bool
     */
    private function validateByAimsinfosoftCount($counts): bool
    {
        $result = true;

        $countString = (string)$counts;
        if ($countString) {
            $moreThan = null;
            $result = false;

            $position = strpos($countString, '>');
            if ($position !== false) {
                $moreThan = substr($countString, $position + 1);
                $moreThan = explode(',', $moreThan);
                $moreThan = array_shift($moreThan);
            }

            $arrCounts = $this->convertToArray($counts);
            $AimsinfosoftModules = $this->getInstalledAimsinfosoftExtensions();
            $dependModules = $this->getDependModules($AimsinfosoftModules);
            $AimsinfosoftModules = array_diff($AimsinfosoftModules, $dependModules);

            $AimsinfosoftCount = count($AimsinfosoftModules);

            if ($AimsinfosoftCount
                && (
                    in_array($AimsinfosoftCount, $arrCounts, false) // non strict
                    || ($moreThan && $AimsinfosoftCount >= $moreThan)
                )
            ) {
                $result = true;
            }
        }

        return $result;
    }

    /**
     * @param string $zones
     *
     * @return bool
     */
    private function validateByDomainZone(string $zones): bool
    {
        $result = true;
        if ($zones) {
            $arrZones = $this->convertToArray($zones);
            $currentZone = $this->feedContentProvider->getDomainZone();

            if (!in_array($currentZone, $arrZones, true)) {
                $result = false;
            }
        }

        return $result;
    }

    /**
     * @param string[] $AimsinfosoftModules
     *
     * @return array
     */
    private function getDependModules(array $AimsinfosoftModules): array
    {
        $depend = [];
        $result = [];
        $dataName = [];
        foreach ($AimsinfosoftModules as $module) {
            $data = $this->moduleInfoProvider->getModuleInfo($module);
            if (isset($data['name'])) {
                $dataName[$data['name']] = $module;
            }

            if (isset($data['require']) && is_array($data['require'])) {
                foreach ($data['require'] as $requireItem => $version) {
                    if (strpos($requireItem, 'Aimsinfosoft') !== false) {
                        $depend[] = $requireItem;
                    }
                }
            }
        }

        $depend = array_unique($depend);
        foreach ($depend as $item) {
            if (isset($dataName[$item])) {
                $result[] = $dataName[$item];
            }
        }

        return $result;
    }

    /**
     * @param \SimpleXMLElement $item
     *
     * @return bool
     */
    private function isItemExists(\SimpleXMLElement $item): bool
    {
        return $this->inboxExistsFactory->create()->execute($item);
    }
}
