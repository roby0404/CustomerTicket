<?php

namespace Inchoo\CustomerTicket\Model\ResourceModel\Ticket;

/**
 * Class Collection
 * @package Inchoo\CustomerTicket\Model\ResourceModel\Ticket
 */
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    protected function _construct()
    {
        $this->_init(
            \Inchoo\CustomerTicket\Model\Ticket::class,
            \Inchoo\CustomerTicket\Model\ResourceModel\Ticket::class
        );
    }

}