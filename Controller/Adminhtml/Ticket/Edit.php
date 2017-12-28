<?php

namespace Inchoo\CustomerTicket\Controller\Adminhtml\Ticket;

use Magento\Framework\Controller\ResultFactory;

/**
 * Class Edit
 * @package Inchoo\CustomerTicket\Controller\Adminhtml\Ticket
 */
class Edit extends \Magento\Cms\Controller\Adminhtml\Block
{

    /**
     * @var \Magento\Framework\App\Request\Http
     */
    protected $request;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\App\Request\Http $request
    )
    {
        $this->request = $request;
        parent::__construct($context, $coreRegistry);
    }

    /**
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);

        $resultPage->setActiveMenu('Inchoo_CustomerTicket::tickets');
        $resultPage->getConfig()->getTitle()->prepend(__('Ticket') . " #" . $this->request->getParam('id'));

        return $resultPage;
    }

}