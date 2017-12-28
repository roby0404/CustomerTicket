<?php

namespace Inchoo\CustomerTicket\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

/**
 * Interface ReplyRepositoryInterface
 * @package Inchoo\CustomerTicket\Api
 */
interface ReplyRepositoryInterface
{

    /**
     * @param Data\ReplyInterface $reply
     * @return mixed
     */
    public function save(Data\ReplyInterface $reply);

    /**
     * @param $ticketId
     * @return mixed
     */
    public function hasReplies($ticketId);

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return mixed
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

}