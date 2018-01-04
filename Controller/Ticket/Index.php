<?php

namespace Inchoo\CustomerTicket\Controller\Ticket;

use Inchoo\CustomerTicket\Api\Data\TicketInterface;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class Index
 * @package Inchoo\CustomerTicket\Controller\Ticket
 */
class Index extends AbstractTicket
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
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * Index constructor.
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Framework\App\Request\Http $request
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Framework\Registry $registry
     * @param \Inchoo\CustomerTicket\Model\TicketRepository $ticketRepository
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\App\Request\Http $request,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Framework\Registry $registry,
        \Inchoo\CustomerTicket\Model\TicketRepository $ticketRepository
    )
    {
        $this->request = $request;
        $this->registry = $registry;
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context, $ticketRepository, $customerSession);
    }

    /**
     * @return \Magento\Framework\Controller\Result\Redirect|\Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        try {
            $ticketId = $this->request->getParam(TicketInterface::TICKET_ID);
            $ticket = $this->_getTicket($ticketId);
            $this->registry->register('ticket', $ticket);

            $resultPage = $this->resultPageFactory->create();
            return $resultPage;
        } catch (NoSuchEntityException $exception) {
            return $this->_redirectWithError();
        }
    }

}