<?php

namespace Inchoo\CustomerTicket\Block;

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
     * @var \Magento\Customer\Model\Session
     */
    protected $customerSession;

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
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Inchoo\CustomerTicket\Api\TicketRepositoryInterface $ticketRepository
     * @param \Inchoo\CustomerTicket\Api\Data\ReopenRequestConfigInterface $reopenRequestConfig
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\App\Request\Http $request,
        \Magento\Customer\Model\Session $customerSession,
        \Inchoo\CustomerTicket\Api\TicketRepositoryInterface $ticketRepository,
        \Inchoo\CustomerTicket\Api\Data\ReopenRequestConfigInterface $reopenRequestConfig
    )
    {
        $this->request = $request;
        $this->customerSession = $customerSession;
        $this->ticketRepository = $ticketRepository;
        $this->reopenReuqestConfig = $reopenRequestConfig;
        parent::__construct($context);
    }

    /**
     * @return mixed
     */
    public function getTicket()
    {
        $ticket = $this->ticketRepository->getById($this->request->getParam('id'), $this->customerSession->getCustomer()->getId());
        if($ticket)
            return $ticket;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        if($this->getTicket())
            return "Ticket #" . $this->request->getParam('id') . "|Created at " . $this->formatDate($this->getTicket()->getCreatedAt(), 3, true) . "|Status: "
                . ucfirst($this->getTicket()->getTicketStatus());
    }

    /**
     * @return mixed
     */
    public function isClosed()
    {
        return $this->ticketRepository->isTicketClosed($this->request->getParam('id'));
    }

    /**
     * @return string
     */
    public function getTicketCloseUrl()
    {
        return $this->getUrl('*/*/close', ['ticket_id' => $this->request->getParam('id')]);
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
        return $this->ticketRepository->isReopenRequested($this->request->getParam('id'));
    }

    /**
     * @return string
     */
    public function getReopenRequestUrl()
    {
        return $this->getUrl('*/*/reopenrequest', ['ticket_id' => $this->request->getParam('id')]);
    }

}