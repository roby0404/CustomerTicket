<?php

namespace Inchoo\CustomerTicket\Model;

/**
 * Class Ticket
 * @package Inchoo\CustomerTicket\Model
 */
class Ticket extends \Magento\Framework\Model\AbstractModel implements \Inchoo\CustomerTicket\Api\Data\TicketInterface
{

    protected function _construct()
    {
        $this->_init(\Inchoo\CustomerTicket\Model\ResourceModel\Ticket::class);
    }

}