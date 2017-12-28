<?php

namespace Inchoo\CustomerTicket\Controller\NewTicket;

use Inchoo\CustomerTicket\Api\Data\TicketInterface;

/**
 * Class SaveTicket
 * @package Inchoo\CustomerTicket\Controller\NewTicket
 */
class SaveTicket extends \Magento\Framework\App\Action\Action
{

    /**
     * @var \Magento\Framework\App\Request\Http
     */
    protected $request;

    /**
     * @var \Magento\Framework\App\Request\DataPersistorInterface
     */
    protected $persistor;

    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $customerSession;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var \Inchoo\CustomerTicket\Api\Data\TicketInterfaceFactory
     */
    protected $ticketFactory;

    /**
     * @var \Inchoo\CustomerTicket\Api\TicketRepositoryInterface
     */
    protected $ticketRepository;

    /**
     * @var \Inchoo\CustomerTicket\Api\Data\UrgencyIndicatorConfigInterface
     */
    protected $urgencyIndicatorConfig;

    /**
     * SaveTicket constructor.
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Framework\App\Request\Http $request
     * @param \Magento\Framework\App\Request\DataPersistorInterface $persistor
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Inchoo\CustomerTicket\Api\Data\TicketInterfaceFactory $ticketFactory
     * @param \Inchoo\CustomerTicket\Api\TicketRepositoryInterface $ticketRepository
     * @param \Inchoo\CustomerTicket\Api\Data\UrgencyIndicatorConfigInterface $urgencyIndicatorConfig
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\App\Request\Http $request,
        \Magento\Framework\App\Request\DataPersistorInterface $persistor,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Inchoo\CustomerTicket\Api\Data\TicketInterfaceFactory $ticketFactory,
        \Inchoo\CustomerTicket\Api\TicketRepositoryInterface $ticketRepository,
        \Inchoo\CustomerTicket\Api\Data\UrgencyIndicatorConfigInterface $urgencyIndicatorConfig
    )
    {
        $this->request = $request;
        $this->persistor = $persistor;
        $this->customerSession = $customerSession;
        $this->storeManager = $storeManager;
        $this->ticketFactory = $ticketFactory;
        $this->ticketRepository = $ticketRepository;
        $this->urgencyIndicatorConfig = $urgencyIndicatorConfig;
        parent::__construct($context);
    }

    /**
     *
     */
    public function execute()
    {
        if(!$this->customerSession->isLoggedIn()) {
            $this->_redirect('/');
        }
        $data = $this->request->getPostValue();
        $ticket = $this->ticketFactory->create();

        $ticket->setCustomerId($this->customerSession->getCustomer()->getId());
        $ticket->setWebsiteId($this->storeManager->getStore()->getWebsiteId());
        $ticket->setTicketSubject($data['subject']);
        $ticket->setTicketMessage($data['message']);
        $ticket->setTicketStatus('open');

        if($this->urgencyIndicatorConfig->isEnabled()) {
            $ticket->setTicketUrgency($data['ticket_urgency']);
        }

        $this->ticketRepository->save($ticket);

        $this->persistor->set('ticket_id', $ticket->getId());

        $this->_redirect(TicketInterface::CUSTOMER_TICKETS_VIEW);
    }

}