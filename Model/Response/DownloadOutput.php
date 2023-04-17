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

namespace Aimsinfosoft\Base\Model\Response;

use Magento\Downloadable\Helper\Download;
use Magento\Framework\Filesystem\File\ReadInterface;

class DownloadOutput extends Download
{
    /**
     * @var ReadInterface|null
     */
    private $resourceHandler;

    public function setResourceHandler(ReadInterface $readResource): self
    {
        $this->resourceHandler = $readResource;

        return $this;
    }

    protected function _getHandle(): ?ReadInterface
    {
        return $this->resourceHandler;
    }
}
