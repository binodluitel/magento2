<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @copyright   Copyright (c) 2014 X.commerce, Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
namespace Magento\Log\Model\Shell\Command;

use Magento\Core\Model\StoreManagerInterface;
use Magento\Log\Model\LogFactory;

class Clean implements \Magento\Log\Model\Shell\CommandInterface
{
    /**
     * @var StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * @var LogFactory
     */
    protected $_logFactory;

    /**
     * Clean after days count
     *
     * @var int
     */
    protected $_days;

    /**
     * @param StoreManagerInterface $storeManager
     * @param LogFactory $logFactory
     * @param int $days
     */
    public function __construct(
        StoreManagerInterface $storeManager,
        LogFactory $logFactory,
        $days
    ) {
        $this->_storeManager = $storeManager;
        $this->_logFactory = $logFactory;
        $this->_days = $days;
    }

    /**
     * Execute command
     *
     * @return string
     */
    public function execute()
    {
        if ($this->_days > 0) {
            $this->_storeManager->getStore()->setConfig(\Magento\Log\Model\Log::XML_LOG_CLEAN_DAYS, $this->_days);
        }
        /** @var $model \Magento\Log\Model\Log */
        $model = $this->_logFactory->create();
        $model->clean();
        return "Log cleaned\n";
    }
}
