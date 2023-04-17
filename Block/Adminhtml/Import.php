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


namespace Aimsinfosoft\Base\Block\Adminhtml;

use Magento\Backend\Block\Template;

class Import extends Template
{
    /**
     * @var string
     */
    private $importEntityTypeCode;

    public function __construct(
        Template\Context $context,
        array $data = []
    ) {
        if (empty($data['entityTypeCode'])) {
            throw new \Aimsinfosoft\Base\Exceptions\EntityTypeCodeNotSet();
        }
        $this->importEntityTypeCode = $data['entityTypeCode'];
        parent::__construct($context, $data);
    }

    public function getImportEntity()
    {
        return $this->importEntityTypeCode;
    }
}
