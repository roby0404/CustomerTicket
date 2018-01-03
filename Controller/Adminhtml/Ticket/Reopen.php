<?php

namespace Inchoo\CustomerTicket\Controller\Adminhtml\Ticket;

use Inchoo\CustomerTicket\Controller\Adminhtml\Ticket\AbstractTicket;
use Inchoo\CustomerTicket\Api\Data\TicketInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class Reopen
 * @package Inchoo\CustomerTicket\Controller\Adminhtml\Ticket
 */
class Reopen extends AbstractTicket
{

    /**
     * @var \Magento\Framework\App\Request\Http
     */
    protected $request;

    /**
     * @var \Inchoo\CustomerTicket\Api\TicketRepositoryInterface
     */
    protected $ticketRepository;

    /**
     * Reopen constructor.
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\App\Request\Http $request
     * @param \Inchoo\CustomerTicket\Api\Data\TicketInterfaceFactory $ticketFactory
     * @param \Inchoo\CustomerTicket\Api\TicketRepositoryInterface $ticketRepository
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\App\Request\Http $request,
        \Inchoo\CustomerTicket\Api\Data\TicketInterfaceFactory $ticketFactory,
        \Inchoo\CustomerTicket\Api\TicketRepositoryInterface $ticketRepository
    )
    {
        $this->request = $request;
        $this->ticketRepository = $ticketRepository;
        parent::__construct($context, $ticketRepository);
    }

    /**
     * @return \Magento\Framework\Controller\Result\Redirect
     */
    public function execute()
    {
        $ticketId = $this->request->getParam(TicketInterface::TICKET_ID);
        try {
            $ticket = $this->_getTicket($ticketId);

            try {
                $this->ticketRepository->reopen($ticket);
                $this->messageManager->addSuccessMessage(__('Ticket reopened successfully'));
            } catch (CouldNotSaveException $exception) {
                $this->messageManager->addErrorMessage(__('Ticket could not be reopened'));
            }
        } catch (NoSuchEntityException $exception) {
            return $this->_redirectWithError();
        }

        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath('*/*/edit', [TicketInterface::TICKET_ID => $ticketId]);
        return $resultRedirect;
    }

}