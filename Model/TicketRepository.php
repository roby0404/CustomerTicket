<?php

namespace Inchoo\CustomerTicket\Model;

use Inchoo\CustomerTicket\Api\Data\TicketInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\CouldNotSaveException;

/**
 * Class TicketRepository
 * @package Inchoo\CustomerTicket\Model
 */
class TicketRepository implements \Inchoo\CustomerTicket\Api\TicketRepositoryInterface
{

    /**
     * @var \Inchoo\CustomerTicket\Api\Data\TicketInterfaceFactory
     */
    protected $ticketFactory;

    /**
     * @var \Inchoo\CustomerTicket\Api\Data\TicketSearchResultsInterfaceFactory
     */
    protected $searchResultsFactory;

    /**
     * @var ResourceModel\Ticket
     */
    protected $ticketResource;

    /**
     * @var ResourceModel\Ticket\CollectionFactory
     */
    protected $ticketCollectionFactory;

    /**
     * @var \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface
     */
    protected $collectionProcessor;

    /**
     * TicketRepository constructor.
     * @param \Inchoo\CustomerTicket\Api\Data\TicketInterfaceFactory $ticketFactory
     * @param \Inchoo\CustomerTicket\Api\Data\TicketSearchResultsInterfaceFactory $searchResultsFactory
     * @param ResourceModel\Ticket $ticketResource
     * @param ResourceModel\Ticket\CollectionFactory $ticketCollectionFactory
     * @param \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        \Inchoo\CustomerTicket\Api\Data\TicketInterfaceFactory $ticketFactory,
        \Inchoo\CustomerTicket\Api\Data\TicketSearchResultsInterfaceFactory $searchResultsFactory,
        \Inchoo\CustomerTicket\Model\ResourceModel\Ticket $ticketResource,
        \Inchoo\CustomerTicket\Model\ResourceModel\Ticket\CollectionFactory $ticketCollectionFactory,
        \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface $collectionProcessor
    )
    {
        $this->ticketFactory = $ticketFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->ticketResource = $ticketResource;
        $this->ticketCollectionFactory = $ticketCollectionFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * @param $ticketId
     * @param string $customerId
     * @return bool
     * @throws NoSuchEntityException
     */
    public function getById($ticketId)
    {
        $ticket = $this->ticketFactory->create();
        $this->ticketResource->load($ticket, $ticketId);

        return !$ticket->getId()? false : $ticket;
    }

    /**
     * @param TicketInterface $ticket
     * @return TicketInterface
     * @throws CouldNotSaveException
     */
    public function save(TicketInterface $ticket)
    {
        try {
            $this->ticketResource->save($ticket);
        } catch(\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }
        return $ticket;
    }

    /**
     * @return mixed
     */
    public function lastInsertId()
    {
        return $this->ticketResource->getConnection()->lastInsertId();
    }

    /**
     * @param TicketInterface $ticket
     * @param $ticketId
     * @return TicketInterface
     * @throws CouldNotSaveException
     */
    public function close(TicketInterface $ticket)
    {
        $ticket->setTicketStatus('closed');
        try {
            $this->ticketResource->save($ticket);
        } catch(\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }
        return $ticket;
    }

    /**
     * @param TicketInterface $ticket
     * @param $ticketId
     * @return TicketInterface
     * @throws CouldNotSaveException
     */
    public function requestReopen(TicketInterface $ticket)
    {
        $ticket->setTicketStatus('reopen requested');
        try {
            $this->ticketResource->save($ticket);
        } catch(\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }
        return $ticket;
    }

    /**
     * @param $customerId
     * @return bool
     */
    public function hasTickets($customerId)
    {
        $collection = $this->ticketCollectionFactory->create();
        $collection->addFieldToFilter(TicketInterface::CUSTOMER_ID, $customerId);
        
        if($collection->getSize() > 0) {
            return true;
        }
        return false;
    }

    /**
     * @param $ticketId
     * @return bool
     */
    public function isTicketClosed($ticketId)
    {
        $ticket = $this->ticketFactory->create();
        $this->ticketResource->load($ticket, $ticketId);
        if($ticket->getTicketStatus() == 'closed') {
            return true;
        }
        return false;
    }

    /**
     * @param $ticketId
     * @return bool
     */
    public function isReopenRequested($ticketId)
    {
        $ticket = $this->ticketFactory->create();
        $this->ticketResource->load($ticket, $ticketId);
        if($ticket->getTicketStatus() == 'reopen requested') {
            return true;
        }
        return false;
    }

    /**
     * @param TicketInterface $ticket
     * @param $ticketId
     * @return TicketInterface
     * @throws CouldNotSaveException
     */
    public function reopen(TicketInterface $ticket)
    {
        $ticket->setTicketStatus('open');
        try {
            $this->ticketResource->save($ticket);
        } catch(\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }
        return $ticket;
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return mixed
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->ticketCollectionFactory->create();

        $this->collectionProcessor->process($searchCriteria, $collection);

        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }

}