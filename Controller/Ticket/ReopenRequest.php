<?php

namespace Inchoo\CustomerTicket\Controller\Ticket;

use Inchoo\CustomerTicket\Api\Data\TicketInterface;

/**
 * Class ReopenRequest
 * @package Inchoo\CustomerTicket\Controller\Ticket
 */
class ReopenRequest extends \Magento\Framework\App\Action\Action
{

    /**
     * @var \Magento\Framework\App\Request\Http
     */
    protected $request;

    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $customerSession;

    /**
     * @var \Inchoo\CustomerTicket\Api\Data\TicketInterfaceFactory
     */
    protected $ticketFactory;

    /**
     * @var \Inchoo\CustomerTicket\Api\TicketRepositoryInterface
     */
    protected $ticketRepository;

    /**
     * @var \Magento\Framework\App\Action\Context
     */
    protected $context;

    /**
     * ReopenRequest constructor.
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Framework\App\Request\Http $request
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Inchoo\CustomerTicket\Api\Data\TicketInterfaceFactory $ticketFactory
     * @param \Inchoo\CustomerTicket\Api\TicketRepositoryInterface $ticketRepository
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\App\Request\Http $request,
        \Magento\Customer\Model\Session $customerSession,
        \Inchoo\CustomerTicket\Api\Data\TicketInterfaceFactory $ticketFactory,
        \Inchoo\CustomerTicket\Api\TicketRepositoryInterface $ticketRepository
    )
    {
        $this->request = $request;
        $this->customerSession = $customerSession;
        $this->ticketFactory = $ticketFactory;
        $this->ticketRepository = $ticketRepository;
        parent::__construct($context);
        $this->context = $context;
    }

    public function execute()
    {
        if(!$this->customerSession->isLoggedIn() || !$this->ticketRepository->getById($this->request->getParam(TicketInterface::TICKET_ID), $this->customerSession->getCustomer()->getId())) {
            $this->_redirect('/');
        }
        $ticket = $this->ticketFactory->create();
        $ticketId = $this->request->getParam(TicketInterface::TICKET_ID);
        $this->ticketRepository->requestReopen($ticket, $ticketId);


        $this->_redirect($this->context->getUrl()->getUrl(TicketInterface::TICKET_URL, ['id' => $this->request->getParam(TicketInterface::TICKET_ID)]));
    }

}