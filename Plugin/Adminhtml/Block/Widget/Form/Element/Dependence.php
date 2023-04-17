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


namespace Aimsinfosoft\Base\Plugin\Adminhtml\Block\Widget\Form\Element;

use Magento\Backend\Block\Widget\Form\Element;

/**
 * Fix group dependence on old Magento
 */
class Dependence
{
    /**
     * @var \Magento\Framework\App\ProductMetadataInterface
     */
    private $productMetadata;

    public function __construct(\Magento\Framework\App\ProductMetadataInterface $productMetadata)
    {
        $this->productMetadata = $productMetadata;
    }

    /**
     * @param Element\Dependence $subject
     * @param \Closure $proceed
     * @param $fieldName
     * @param $fieldNameFrom
     * @param $refField
     * @return Element\Dependence
     */
    public function aroundAddFieldDependence(
        Element\Dependence $subject,
        \Closure $proceed,
        $fieldName,
        $fieldNameFrom,
        $refField
    ) {
        if (version_compare($this->productMetadata->getVersion(), '2.2.0', '<')
            && strpos($fieldName, 'groups[][fields]') !== false
        ) {
            return $subject;
        }

        return $proceed($fieldName, $fieldNameFrom, $refField);
    }
}
