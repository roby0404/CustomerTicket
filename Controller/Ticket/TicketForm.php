<?php

namespace Inchoo\CustomerTicket\Controller\Ticket;

/**
 * Class TicketForm
 * @package Inchoo\CustomerTicket\Controller\NewTicket
 */
class TicketForm extends AbstractTicket
{

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * TicketForm constructor.
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Inchoo\CustomerTicket\Api\TicketRepositoryInterface $ticketRepository
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Customer\Model\Session $customerSession,
        \Inchoo\CustomerTicket\Api\TicketRepositoryInterface $ticketRepository
    )
    {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context, $ticketRepository, $customerSession);
    }

    /**
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        return $resultPage;
    }

}