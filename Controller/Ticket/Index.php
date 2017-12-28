<?php

namespace Inchoo\CustomerTicket\Controller\Ticket;

/**
 * Class Index
 * @package Inchoo\CustomerTicket\Controller\Ticket
 */
class Index extends \Magento\Framework\App\Action\Action
{

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var \Magento\Framework\App\Request\Http
     */
    protected $request;

    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $customerSession;

    /**
     * @var \Inchoo\CustomerTicket\Model\TicketRepository
     */
    protected $ticketRepository;

    /**
     * Index constructor.
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Framework\App\Request\Http $request
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Inchoo\CustomerTicket\Model\TicketRepository $ticketRepository
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\App\Request\Http $request,
        \Magento\Customer\Model\Session $customerSession,
        \Inchoo\CustomerTicket\Model\TicketRepository $ticketRepository
    )
    {
        $this->resultPageFactory = $resultPageFactory;
        $this->request = $request;
        $this->customerSession = $customerSession;
        $this->ticketRepository = $ticketRepository;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        if(!$this->customerSession->isLoggedIn() || !$this->ticketRepository->getById($this->request->getParam('id'), $this->customerSession->getCustomer()->getId())) {
            $this->_redirect('/');
        }
        $resultPage = $this->resultPageFactory->create();

        return $resultPage;
    }

}