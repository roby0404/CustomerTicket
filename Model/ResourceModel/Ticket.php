<?php

namespace Inchoo\CustomerTicket\Model\ResourceModel;

/**
 * Class Ticket
 * @package Inchoo\CustomerTicket\Model\ResourceModel
 */
class Ticket extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

    protected function _construct()
    {
        $this->_init('customer_ticket', 'ticket_id');
    }

}