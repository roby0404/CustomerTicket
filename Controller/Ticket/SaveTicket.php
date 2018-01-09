<?php

namespace Inchoo\CustomerTicket\Controller\Ticket;

use Inchoo\CustomerTicket\Api\Data\TicketInterface;
use Magento\Framework\Exception\CouldNotSaveException;

/**
 * Class SaveTicket
 * @package Inchoo\CustomerTicket\Controller\NewTicket
 */
class SaveTicket extends AbstractTicket
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
     * @var \Magento\Framework\Module\Manager
     */
    protected $moduleManager;

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
     * @param \Magento\Framework\Module\Manager $moduleManager
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
        \Magento\Framework\Module\Manager $moduleManager,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Inchoo\CustomerTicket\Api\Data\TicketInterfaceFactory $ticketFactory,
        \Inchoo\CustomerTicket\Api\TicketRepositoryInterface $ticketRepository,
        \Inchoo\CustomerTicket\Api\Data\UrgencyIndicatorConfigInterface $urgencyIndicatorConfig
    )
    {
        $this->request = $request;
        $this->persistor = $persistor;
        $this->moduleManager = $moduleManager;
        $this->customerSession = $customerSession;
        $this->storeManager = $storeManager;
        $this->ticketFactory = $ticketFactory;
        $this->ticketRepository = $ticketRepository;
        $this->urgencyIndicatorConfig = $urgencyIndicatorConfig;
        parent::__construct($context, $ticketRepository, $customerSession);
    }

    /**
     * @return \Magento\Framework\Controller\Result\Redirect
     */
    public function execute()
    {
            $data = $this->request->getPostValue();
            $ticket = $this->ticketFactory->create();

            $ticket->setCustomerId($this->customerSession->getCustomerId());
            $ticket->setWebsiteId($this->storeManager->getStore()->getWebsiteId());
            $ticket->setTicketSubject($data['subject']);
            $ticket->setTicketMessage($data['message']);

            if($this->urgencyIndicatorConfig->isEnabled()) {
                $ticket->setTicketUrgency($data['ticket_urgency']);
            }

            try {
                $this->ticketRepository->save($ticket);
                $this->messageManager->addSuccessMessage(__('Ticket submitted successfully'));

                if($this->moduleManager->isEnabled('Inchoo_TicketMail')) {
                    $this->persistor->set('ticket_id', $ticket->getId());
                }
            } catch (CouldNotSaveException $exception) {
                $this->messageManager->addErrorMessage(__('Ticket is not saved'));
            }

        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath(TicketInterface::CUSTOMER_TICKETS_VIEW);
        return $resultRedirect;
    }

}