<?php

namespace Inchoo\CustomerTicket\Model;

/**
 * Class Reply
 * @package Inchoo\CustomerTicket\Model
 */
class Reply extends \Magento\Framework\Model\AbstractModel implements \Inchoo\CustomerTicket\Api\Data\ReplyInterface
{

    protected function _construct()
    {
        $this->_init(\Inchoo\CustomerTicket\Model\ResourceModel\Reply::class);
    }

}