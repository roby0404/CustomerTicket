<?php

namespace Inchoo\CustomerTicket\Block;

use Inchoo\CustomerTicket\Api\Data\TicketInterface;
use Inchoo\CustomerTicket\Api\TicketRepositoryInterface;

/**
 * Class MyTicket
 * @package Inchoo\CustomerTicket\Block
 */
class MyTicket extends \Magento\Framework\View\Element\Template
{

    /**
     * @var \Magento\Framework\App\Request\Http
     */
    protected $request;

    /**
     * @var \Magento\Framework\Registry
     */
    protected $registry;

    /**
     * @var \Inchoo\CustomerTicket\Api\TicketRepositoryInterface
     */
    protected $ticketRepository;

    /**
     * @var \Inchoo\CustomerTicket\Api\Data\ReopenRequestConfigInterface
     */
    protected $reopenReuqestConfig;

    /**
     * MyTicket constructor.
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Framework\App\Request\Http $request
     * @param \Magento\Framework\Registry $registry
     * @param TicketRepositoryInterface $ticketRepository
     * @param \Inchoo\CustomerTicket\Api\Data\ReopenRequestConfigInterface $reopenRequestConfig
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\App\Request\Http $request,
        \Magento\Framework\Registry $registry,
        \Inchoo\CustomerTicket\Api\TicketRepositoryInterface $ticketRepository,
        \Inchoo\CustomerTicket\Api\Data\ReopenRequestConfigInterface $reopenRequestConfig
    )
    {
        $this->request = $request;
        $this->registry = $registry;
        $this->ticketRepository = $ticketRepository;
        $this->reopenReuqestConfig = $reopenRequestConfig;
        parent::__construct($context);
    }

    /**
     * @return mixed
     */
    public function getTicket()
    {
        $ticket = $this->registry->registry('ticket');
        if($ticket)
            return $ticket;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        if(!is_null($this->getTicket()))
            return "Ticket #" . $this->request->getParam(TicketInterface::TICKET_ID)
                . "|Created at " . $this->formatDate($this->getTicket()->getCreatedAt(), 3, true)
                . "|Status: " . ucfirst(TicketInterface::TICKET_STATUS_ARRAY[$this->getTicket()->getTicketStatus()]);
    }

    /**
     * @return mixed
     */
    public function isClosed()
    {
        return $this->ticketRepository->isTicketClosed($this->request->getParam(TicketInterface::TICKET_ID));
    }

    /**
     * @return string
     */
    public function getTicketCloseUrl()
    {
        return $this->getUrl(TicketInterface::CLOSE_URL, [TicketInterface::TICKET_ID => $this->request->getParam(TicketInterface::TICKET_ID)]);
    }

    /**
     * @return string
     */
    public function getReopenRequestUrl()
    {
        return $this->getUrl(TicketInterface::REQUEST_REOPEN_URL, [TicketInterface::TICKET_ID => $this->request->getParam(TicketInterface::TICKET_ID)]);
    }

    /**
     * @return mixed
     */
    public function isReopenEnabled()
    {
        return $this->reopenReuqestConfig->isEnabled();
    }

    /**
     * @return mixed
     */
    public function isReopenRequested()
    {
        return $this->ticketRepository->isReopenRequested($this->request->getParam(TicketInterface::TICKET_ID));
    }

}