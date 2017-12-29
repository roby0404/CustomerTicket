<?php

namespace Inchoo\CustomerTicket\Block;

use Magento\Framework\Api\SortOrder;
use Inchoo\CustomerTicket\Api\Data\ReplyInterface;

/**
 * Class TicketReplies
 * @package Inchoo\CustomerTicket\Block
 */
class TicketReplies extends \Magento\Framework\View\Element\Template
{

    /**
     * @var \Magento\Framework\App\Request\Http
     */
    protected $request;

    /**
     * @var \Magento\Framework\Api\SearchCriteriaBuilder
     */
    protected $searchCriteriaBuilder;

    /**
     * @var \Magento\Framework\Api\SortOrderBuilder
     */
    protected $sortOrderBuilder;

    /**
     * @var \Inchoo\CustomerTicket\Api\TicketRepositoryInterface
     */
    protected $ticketRepository;

    /**
     * @var \Inchoo\CustomerTicket\Api\ReplyRepositoryInterface
     */
    protected $replyRepository;

    /**
     * TicketReplies constructor.
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Framework\App\Request\Http $request
     * @param \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder
     * @param \Magento\Framework\Api\SortOrderBuilder $sortOrderBuilder
     * @param \Inchoo\CustomerTicket\Api\TicketRepositoryInterface $ticketRepository
     * @param \Inchoo\CustomerTicket\Api\ReplyRepositoryInterface $replyRepository
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\App\Request\Http $request,
        \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder,
        \Magento\Framework\Api\SortOrderBuilder $sortOrderBuilder,
        \Inchoo\CustomerTicket\Api\TicketRepositoryInterface $ticketRepository,
        \Inchoo\CustomerTicket\Api\ReplyRepositoryInterface $replyRepository
    )
    {
        $this->request = $request;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->sortOrderBuilder = $sortOrderBuilder;
        $this->ticketRepository = $ticketRepository;
        $this->replyRepository = $replyRepository;
        parent::__construct($context);
    }

    /**
     * @return mixed
     */
    public function getTicketId()
    {
        return $this->request->getParam(ReplyInterface::TICKET_ID);
    }

    /**
     * @return string
     */
    public function getSubmitUrl()
    {
        return $this->getUrl(ReplyInterface::SUBMIT_URL, [ReplyInterface::TICKET_ID => $this->getTicketId()]);
    }

    /**
     * @return mixed
     */
    public function hasReplies()
    {
        return $this->replyRepository->hasReplies($this->getTicketId());
    }

    /**
     * @return mixed
     */
    public function isClosed()
    {
        return $this->ticketRepository->isTicketClosed($this->getTicketId());
    }

    /**
     * @return mixed
     */
    public function isReopenRequested()
    {
        return $this->ticketRepository->isReopenRequested($this->request->getParam(ReplyInterface::TICKET_ID));
    }


    /**
     * @return mixed
     */
    public function replyList()
    {
        $sortOrder = $this->sortOrderBuilder->setField(ReplyInterface::CREATED_AT)->setDirection(SortOrder::SORT_ASC)->create();
        $this->searchCriteriaBuilder->setSortOrders([$sortOrder]);
        $searchCriteria = $this->searchCriteriaBuilder->addFilter(ReplyInterface::TICKET_ID, $this->getTicketId())->create();

        $searchResults = $this->replyRepository->getList($searchCriteria);

        return $searchResults->getItems();
    }

}