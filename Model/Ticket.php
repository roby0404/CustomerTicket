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

    /**
     * @param $customerId
     * @return bool
     */
    public function confirmTicketOwnership($customerId)
    {
        return $this->_confirmTicketOwnership($customerId);
    }

    /**
     * @param $customerId
     * @return bool
     */
    protected function _confirmTicketOwnership($customerId)
    {
        if($this->getData(self::CUSTOMER_ID) == $customerId) {
            return true;
        } else {
            return false;
        }
    }

}