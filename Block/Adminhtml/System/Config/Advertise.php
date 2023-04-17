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


namespace Aimsinfosoft\Base\Block\Adminhtml\System\Config;

use Magento\Backend\Block\Template\Context;
use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;

/**
 * Class Advertise for adding advertise
 */
class Advertise extends Field
{
    /**
     * @param AbstractElement $element
     *
     * @return string
     */
    public function render(AbstractElement $element)
    {
        $commentText = $element->getContainer()->getGroup()['data']['text'];
        $element->setValue(__('Not Installed'));
        $element->setHtmlId('aimsinfosoft_not_instaled');
        $element->setComment(__($commentText));
        $element->setLabel(__('Status'));

        return parent::render($element);
    }

    /**
     * @inheritDoc
     */
    protected function _renderScopeLabel(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        return '';
    }

    /**
     * @inheritDoc
     */
    protected function _isInheritCheckboxRequired(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        return false;
    }

    /**
     * @inheritDoc
     */
    protected function _renderInheritCheckbox(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        return '';
    }
}
