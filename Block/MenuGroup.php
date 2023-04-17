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

namespace Aimsinfosoft\Base\Block;

use Magento\Config\Block\System\Config\Form\Fieldset;
use Magento\Framework\App\ProductMetadataInterface;
use Magento\Framework\Data\Form\Element\AbstractElement;

class MenuGroup extends Fieldset
{
    /**
     * @var ProductMetadataInterface
     */
    private $metadata;

    public function __construct(
        ProductMetadataInterface $metadata,
        \Magento\Backend\Block\Context $context,
        \Magento\Backend\Model\Auth\Session $authSession,
        \Magento\Framework\View\Helper\Js $jsHelper,
        array $data = []
    ) {
        parent::__construct($context, $authSession, $jsHelper, $data);
        $this->metadata = $metadata;
    }

    public function render(AbstractElement $element)
    {
        if (version_compare($this->metadata->getVersion(), '2.2.0', '>=')) {
            return parent::render($element);
        }

        return '';
    }
}
