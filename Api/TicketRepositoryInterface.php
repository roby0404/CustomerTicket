<?php

namespace Inchoo\CustomerTicket\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

/**
 * Interface TicketRepositoryInterface
 * @package Inchoo\CustomerTicket\Api
 */
interface TicketRepositoryInterface
{

    /**
     * @param $ticketId
     * @return mixed
     */
    public function getById($ticketId, $customerId = '');

    /**
     * @param Data\TicketInterface $
     * @return mixed
     */
    public function save(Data\TicketInterface $ticket);

    /**
     * @return mixed
     */
    public function lastInsertId();

    /**
     * @param Data\TicketInterface $ticket
     * @param $ticketId
     * @return mixed
     */
    public function close(Data\TicketInterface $ticket, $ticketId);

    /**
     * @param Data\TicketInterface $ticket
     * @param $ticketId
     * @return mixed
     */
    public function requestReopen(Data\TicketInterface $ticket, $ticketId);

    /**
     * @param $customerId
     * @return mixed
     */
    public function hasTickets($customerId);

    /**
     * @param $ticketId
     * @return mixed
     */
    public function isTicketClosed($ticketId);

    /**
     * @param $ticketId
     * @return mixed
     */
    public function isReopenRequested($ticketId);

    /**
     * @param $ticketId
     * @return mixed
     */
    public function reopen(Data\TicketInterface $ticket, $ticketId);

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return mixed
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

}