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


namespace Aimsinfosoft\Base\Helper;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\App\Helper\AbstractHelper;

class Deploy extends AbstractHelper
{
    /**
     * @var \Magento\Framework\Filesystem\Directory\Write
     */
    protected $rootWrite;

    /**
     * @var \Magento\Framework\Filesystem\Directory\Read
     */
    protected $rootRead;

    /**
     * @var \Magento\Framework\Filesystem
     */
    protected $filesystem;

    public const DEFAULT_FILE_PERMISSIONS = 0666;
    public const DEFAULT_DIR_PERMISSIONS = 0777;

    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Aimsinfosoft\Base\Model\FilesystemProvider $filesystemProvider
    ) {
        parent::__construct($context);
        $this->filesystem = $filesystemProvider->get();
        $this->rootWrite = $this->filesystem->getDirectoryWrite(DirectoryList::ROOT);
        $this->rootRead = $this->filesystem->getDirectoryRead(DirectoryList::ROOT);
    }

    public function deployFolder($folder)
    {
        $from = $this->rootRead->getRelativePath($folder);
        $this->moveFilesFromTo($from, '');
    }

    public function moveFilesFromTo($fromPath, $toPath)
    {
        //phpcs:ignore
        $baseName = basename($fromPath);
        $files = $this->rootRead->readRecursively($fromPath);
        array_unshift($files, $fromPath);

        foreach ($files as $file) {
            $newFileName = $this->getNewFilePath(
                $file,
                $fromPath,
                ltrim($toPath . '/' . $baseName, '/')
            );

            if ($this->rootRead->isExist($newFileName)) {
                continue;
            }

            if ($this->rootRead->isFile($file)) {
                $this->rootWrite->copyFile($file, $newFileName);

                $this->rootWrite->changePermissions(
                    $newFileName,
                    self::DEFAULT_FILE_PERMISSIONS
                );
            } elseif ($this->rootRead->isDirectory($file)) {
                $this->rootWrite->create($newFileName);

                $this->rootWrite->changePermissions(
                    $newFileName,
                    self::DEFAULT_DIR_PERMISSIONS
                );
            }
        }
    }

    protected function getNewFilePath($filePath, $fromPath, $toPath)
    {
        return str_replace($fromPath, $toPath, $filePath);
    }
}
