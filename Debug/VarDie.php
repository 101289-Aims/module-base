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


namespace Aimsinfosoft\Base\Debug;

/**
 * For Remote Debug
 * Same as VarDump class but with 'exit' after execution
 * @codeCoverageIgnore
 * @codingStandardsIgnoreFile
 */
class VarDie
{
    public static function execute()
    {
        if (VarDump::isAllowed()) {
            foreach (func_get_args() as $var) {
                System\Beautifier::getInstance()->beautify(VarDump::dump($var));
            }
            VarDump::AimsinfosoftExit();
        }
    }

    public static function backtrace()
    {
        if (VarDump::isAllowed()) {
            $backtrace = debug_backtrace();
            array_shift($backtrace);
            foreach ($backtrace as $route) {
                System\Beautifier::getInstance()->beautify(
                    VarDump::dump(
                        [
                            'action' => $route['class'] . $route['type'] . $route['function'] . '()',
                            'object' => $route['object'],
                            'args' => $route['args'],
                            'file' => $route['file'] . ':' . $route['line']
                        ]
                    )
                );
            }
            VarDump::AimsinfosoftExit();
        }
    }
}
