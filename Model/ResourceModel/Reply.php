<?php

namespace Inchoo\CustomerTicket\Model\ResourceModel;

/**
 * Class Reply
 * @package Inchoo\CustomerTicket\Model\ResourceModel
 */
class Reply extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

    protected function _construct()
    {
        $this->_init('customer_ticket_reply', 'reply_id');
    }

}