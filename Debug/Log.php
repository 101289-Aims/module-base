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
 * Output is going to file Aimsinfosoft_debug.log
 * @codeCoverageIgnore
 * @codingStandardsIgnoreFile
 */
class Log
{
    /**
     * @var \Magento\Framework\Logger\Monolog
     */
    private static $loggerInstance;

    /**
     * @var string
     */
    private static $fileToLog = 'Aimsinfosoft_debug.log';

    public static function execute()
    {
        if (VarDump::isAllowed()) {
            foreach (func_get_args() as $var) {
                self::logToFile(
                    System\LogBeautifier::getInstance()->beautify(
                        VarDump::dump($var)
                    )
                );
            }
        }
    }

    /**
     * @param int $level
     */
    public static function setObjectDepthLevel($level)
    {
        VarDump::setObjectDepthLevel((int)$level);
    }

    /**
     * @param int $level
     */
    public static function setArrayDepthLevel($level)
    {
        VarDump::setArrayDepthLevel((int)$level);
    }

    /**
     * @param string $filename
     */
    public static function setLogFile($filename)
    {
        if (preg_match('/^[a-z_]+\.log$/i', $filename)) {
            self::$fileToLog = $filename;
        }
    }

    /**
     * Log debug_backtrace
     */
    public static function backtrace()
    {
        if (VarDump::isAllowed()) {
            $backtrace = debug_backtrace();
            array_shift($backtrace);
            foreach ($backtrace as $key => $route) {
                $backtrace[$key] = [
                    'action' => $route['class'] . $route['type'] . $route['function'] . '()',
                    'file' => $route['file'] . ':' . $route['line']
                ];
            }
            self::logToFile(System\LogBeautifier::getInstance()->beautify(VarDump::dump($backtrace)));
        }
    }

    /**
     * @param string $var
     */
    private static function logToFile($var)
    {
        self::getLogger()->addRecord(200, $var);
    }

    /**
     * @return \Magento\Framework\Logger\Monolog
     */
    private static function getLogger()
    {
        if (!self::$loggerInstance) {
            self::configureInstance();
        }
        return self::$loggerInstance;
    }

    private static function configureInstance()
    {
        $logDir = \Magento\Framework\App\ObjectManager::getInstance()
            ->get('\Magento\Framework\Filesystem\DirectoryList')
            ->getPath('log');
        $handler = new \Monolog\Handler\RotatingFileHandler($logDir . DIRECTORY_SEPARATOR . self::$fileToLog, 2);

        $output = "\n----------------------------------------------------------------------------\n%datetime%\n
%message%
----------------------------------------------------------------------------\n\n";
        $formatter = new System\AimsinfosoftFormatter($output);

        $handler->setFormatter($formatter);
        self::$loggerInstance = new \Magento\Framework\Logger\Monolog('Aimsinfosoft_logger', [$handler]);
    }
}
