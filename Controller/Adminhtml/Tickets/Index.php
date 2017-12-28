<?php

namespace Inchoo\CustomerTicket\Controller\Adminhtml\Tickets;

use Magento\Framework\Controller\ResultFactory;

/**
 * Class Index
 * @package Inchoo\CustomerTicket\Controller\Adminhtml\Tickets
 */
class Index extends \Magento\Backend\App\Action
{

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Inchoo_CustomerTicket::tickets');
    }

    /**
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);

        $resultPage->setActiveMenu('Inchoo_CustomerTicket::tickets');
        $resultPage->getConfig()->getTitle()->prepend(__('Tickets'));

        return $resultPage;
    }

}