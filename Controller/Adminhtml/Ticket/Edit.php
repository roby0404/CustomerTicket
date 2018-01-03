<?php

namespace Inchoo\CustomerTicket\Controller\Adminhtml\Ticket;

use Inchoo\CustomerTicket\Api\TicketRepositoryInterface;
use Inchoo\CustomerTicket\Controller\Adminhtml\Ticket\AbstractTicket;
use Inchoo\CustomerTicket\Api\Data\TicketInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class Edit
 * @package Inchoo\CustomerTicket\Controller\Adminhtml\Ticket
 */
class Edit extends AbstractTicket
{

    /**
     * @var \Magento\Framework\App\Request\Http
     */
    protected $request;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Inchoo\CustomerTicket\Api\TicketRepositoryInterface $ticketRepository,
        \Magento\Framework\App\Request\Http $request
    )
    {
        $this->request = $request;
        parent::__construct($context, $ticketRepository);
    }

    /**
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);

        $ticketId = $this->request->getParam(TicketInterface::TICKET_ID);

        try {
            $this->_getTicket($ticketId);
        } catch (NoSuchEntityException $exception){
           return $this->_redirectWithError();
        }

        $resultPage->setActiveMenu('Inchoo_CustomerTicket::tickets');
        $resultPage->getConfig()->getTitle()->prepend(__('Ticket') . " #" . $ticketId);

        return $resultPage;

    }

}