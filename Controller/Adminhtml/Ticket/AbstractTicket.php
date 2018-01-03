<?php

namespace Inchoo\CustomerTicket\Controller\Adminhtml\Ticket;

use Magento\Framework\Exception\NoSuchEntityException;

abstract class AbstractTicket extends \Magento\Backend\App\Action
{

    protected $ticketRepository;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Inchoo\CustomerTicket\Api\TicketRepositoryInterface $ticketRepository
    )
    {
        $this->ticketRepository = $ticketRepository;
        parent::__construct($context);
    }

    protected function _getTicket($id)
    {
        $ticket = $this->ticketRepository->getById($id);

        if ($ticket) {
            return $ticket;
        }
        throw new NoSuchEntityException();
    }

    protected function _redirectWithError()
    {
        $this->messageManager->addErrorMessage(__('Ticket not found'));
        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath('ticket/tickets/index');

        return $resultRedirect;
    }

}