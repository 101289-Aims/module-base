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


namespace Aimsinfosoft\Base\Model\Import\Validation;

use Aimsinfosoft\Base\Model\Import\AbstractImport;

class Validator implements ValidatorInterface
{
    /**
     * @var \Magento\Framework\DataObject
     */
    protected $validationData;

    public function __construct(\Magento\Framework\DataObject $validationData)
    {
        $this->validationData = $validationData;
    }

    /**
     * @var array
     */
    protected $errors = [];

    /**
     * @var array
     */
    protected $messageTemplates = [

    ];

    /**
     * @inheritdoc
     */
    public function validateRow(array $rowData, $behavior)
    {
        return true;
    }

    /**
     * Usual behavior at the end of validation. Help function
     *
     * @return array|bool
     */
    public function validateResult()
    {
        if ($this->errors) {
            return $this->errors;
        }

        return true;
    }

    /**
     * @inheritdoc
     */
    public function getErrorMessages()
    {
        return $this->messageTemplates;
    }

    /**
     * @inheritDoc
     */
    public function addRuntimeError($message, $level)
    {
        if (!isset($this->errors[AbstractImport::RUNTIME_ERRORS])) {
            $this->errors[AbstractImport::RUNTIME_ERRORS] = [];
        }

        $this->errors[AbstractImport::RUNTIME_ERRORS][(string)(__('<b>Error!</b> ')) . $message] = $level;

        return $this;
    }
}
