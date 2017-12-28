<?php

namespace Inchoo\CustomerTicket\Controller\Adminhtml\Ticket;

/**
 * Class Reopen
 * @package Inchoo\CustomerTicket\Controller\Adminhtml\Ticket
 */
class Reopen extends \Magento\Backend\App\Action
{

    /**
     * @var \Magento\Framework\App\Request\Http
     */
    protected $request;

    /**
     * @var \Inchoo\CustomerTicket\Api\Data\TicketInterfaceFactory
     */
    protected $ticketFactory;

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
        $this->ticketFactory = $ticketFactory;
        $this->ticketRepository = $ticketRepository;
        parent::__construct($context);
    }

    public function execute()
    {
        $id = $this->request->getParam('ticket_id');
        $ticket = $this->ticketFactory->create();

        $this->ticketRepository->reopen($ticket, $id);

        $this->_redirect('ticket/ticket/edit/id/' . $id);
    }

}