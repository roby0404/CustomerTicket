<?php

namespace Inchoo\CustomerTicket\Block;

use Magento\Framework\Api\SortOrder;
use Inchoo\CustomerTicket\Api\Data\TicketInterface;

/**
 * Class MyTickets
 * @package Inchoo\CustomerTicket\Block
 */
class MyTickets extends \Magento\Framework\View\Element\Template
{

    /**
     * @var \Magento\Framework\Api\SearchCriteriaBuilder
     */
    protected $searchCriteriaBuilder;

    /**
     * @var \Magento\Framework\Api\SortOrderBuilder
     */
    protected $sortOrderBuilder;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $customerSession;

    /**
     * @var \Inchoo\CustomerTicket\Api\TicketRepositoryInterface
     */
    protected $ticketRepository;

    /**
     * MyTickets constructor.
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder
     * @param \Magento\Framework\Api\SortOrderBuilder $sortOrderBuilder
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Inchoo\CustomerTicket\Api\TicketRepositoryInterface $ticketRepository
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder,
        \Magento\Framework\Api\SortOrderBuilder $sortOrderBuilder,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Customer\Model\Session $customerSession,
        \Inchoo\CustomerTicket\Api\TicketRepositoryInterface $ticketRepository
    )
    {
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->sortOrderBuilder = $sortOrderBuilder;
        $this->storeManager = $storeManager;
        $this->customerSession = $customerSession;
        $this->ticketRepository = $ticketRepository;
        parent::__construct($context);
    }

    /**
     * @return mixed
     */
    public function hasTickets()
    {
        return $this->ticketRepository->hasTickets($this->customerSession->getCustomer()->getId());
    }

    /**
     * @return mixed
     */
    public function ticketList()
    {
        $sortOrder = $this->sortOrderBuilder->setField(TicketInterface::CREATED_AT)->setDirection(SortOrder::SORT_DESC)->create();
        $this->searchCriteriaBuilder->setSortOrders([$sortOrder]);
        $searchCriteria = $this->searchCriteriaBuilder->addFilter(TicketInterface::CUSTOMER_ID, $this->customerSession->getCustomer()->getId())
                                                      ->addFilter(TicketInterface::WEBSITE_ID, $this->storeManager->getStore()->getWebsiteId())
                                                      ->create();

        $searchResults = $this->ticketRepository->getList($searchCriteria);

        return $searchResults->getItems();
    }

    /**
     * @return string
     */
    public function getNewTicketFormLink()
    {
        return $this->getUrl(TicketInterface::FORM_URL);
    }

    /**
     * @return string
     */
    public function getTicketUrl()
    {
        return TicketInterface::TICKET_URL;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return "My Tickets";
    }

    /**
     * @return array
     */
    public function getTicketStatusArray()
    {
        return TicketInterface::TICKET_STATUS_ARRAY;
    }

}