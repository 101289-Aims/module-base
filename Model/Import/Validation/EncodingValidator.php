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

use Magento\ImportExport\Model\Import\ErrorProcessing\ProcessingError;

class EncodingValidator extends Validator implements ValidatorInterface
{
    public const ENCODING_ERROR = 'encodingError';

    /**
     * @var array
     */
    protected $messageTemplates = [
        self::ENCODING_ERROR => '<b>Error!</b> Row has characters with Wrong Encoding'
    ];

    /**
     * @inheritdoc
     */
    public function validateRow(array $rowData, $behavior)
    {
        $this->errors = [];
        foreach ($rowData as $value) {
            if (!mb_check_encoding((string)$value, 'UTF-8')) {
                $this->errors[self::ENCODING_ERROR] = ProcessingError::ERROR_LEVEL_CRITICAL;
                break;
            }
        }

        return parent::validateResult();
    }
}
