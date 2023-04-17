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


namespace Aimsinfosoft\Base\Component;

/**
 * ComponentRegistrar class is necessary for external sample files.
 * By default Magento_ImportExport Download Controller checks only Magento_ImportExport sample files folder.
 */
class ComponentRegistrar extends \Magento\Framework\Component\ComponentRegistrar
{
    /**
     * @var \Magento\Framework\App\RequestInterface
     */
    private $request;

    /**
     * @var \Magento\Framework\DataObject
     */
    private $samples;

    /**
     * ComponentRegistrar constructor.
     * @param \Magento\Framework\App\RequestInterface $request
     * @param \Magento\Framework\DataObject $samples
     */
    public function __construct(
        \Magento\Framework\App\RequestInterface $request,
        \Magento\Framework\DataObject $samples
    ) {
        $this->request = $request;
        $this->samples = $samples;
    }

    /**
     * {@inheritdoc}
     */
    public function getPath($type, $componentName)
    {
        $moduleName = $this->samples->getData($this->request->getParam('filename'));
        if ($moduleName) {
            $componentName = $moduleName;
        }
        return parent::getPath($type, $componentName);
    }
}
