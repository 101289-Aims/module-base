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

namespace Aimsinfosoft\Base\Utils\Http\Url;

class UrlComparator
{
    /**
     * Check two urls, if the first url contains a mask (for example {})
     * and urls differ only by mask then urls is equals
     *
     * @param string $url1
     * @param string $url2
     * @param string $mask
     * @return bool
     */
    public function isEqual(string $url1, string $url2, string $mask = '{}'): bool
    {
        $result = true;
        $arrUrl1 = explode('/', $url1);
        $arrUrl2 = explode('/', $url2);
        $diff = array_diff($arrUrl1, $arrUrl2);

        foreach ($diff as $value) {
            if ($value != $mask) {
                $result = false;
                break;
            }
        }

        return $result;
    }
}
