<?php

namespace Inchoo\CustomerTicket\Model;

use Inchoo\CustomerTicket\Api\Data\ReplyInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotSaveException;

class ReplyRepository implements \Inchoo\CustomerTicket\Api\ReplyRepositoryInterface
{

    /**
     * @var \Inchoo\CustomerTicket\Api\Data\ReplyInterfaceFactory
     */
    protected $replyFactory;

    /**
     * @var \Inchoo\CustomerTicket\Api\Data\ReplySearchResultsInterfaceFactory
     */
    protected $searchResultsFactory;

    /**
     * @var ResourceModel\Reply
     */
    protected $replyResource;

    /**
     * @var ResourceModel\Reply\CollectionFactory
     */
    protected $replyCollectionFactory;

    /**
     * @var \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface
     */
    protected $collectionProcessor;

    /**
     * ReplyRepository constructor.
     * @param \Inchoo\CustomerTicket\Api\Data\ReplyInterfaceFactory $replyFactory
     * @param \Inchoo\CustomerTicket\Api\Data\ReplySearchResultsInterfaceFactory $searchResultsFactory
     * @param ResourceModel\Reply $replyResource
     * @param ResourceModel\Reply\CollectionFactory $replyCollectionFactory
     * @param \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        \Inchoo\CustomerTicket\Api\Data\ReplyInterfaceFactory $replyFactory,
        \Inchoo\CustomerTicket\Api\Data\ReplySearchResultsInterfaceFactory $searchResultsFactory,
        \Inchoo\CustomerTicket\Model\ResourceModel\Reply $replyResource,
        \Inchoo\CustomerTicket\Model\ResourceModel\Reply\CollectionFactory $replyCollectionFactory,
        \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface $collectionProcessor
    )
    {
        $this->replyFactory = $replyFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->replyResource = $replyResource;
        $this->replyCollectionFactory = $replyCollectionFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * @param ReplyInterface $reply
     * @return ReplyInterface
     * @throws CouldNotSaveException
     */
    public function save(ReplyInterface $reply)
    {
        try {
            $this->replyResource->save($reply);
        } catch(\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }
        return $reply;
    }

    /**
     * @param $ticketId
     * @return bool
     */
    public function hasReplies($ticketId)
    {
        $collection = $this->replyCollectionFactory->create();
        $collection->addFieldToFilter(ReplyInterface::TICKET_ID, $ticketId);

        if($collection->getSize() > 0) {
            return true;
        }
        return false;
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return mixed
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->replyCollectionFactory->create();

        $this->collectionProcessor->process($searchCriteria, $collection);

        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }

}