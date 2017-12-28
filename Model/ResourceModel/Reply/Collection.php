<?php

namespace Inchoo\CustomerTicket\Model\ResourceModel\Reply;

/**
 * Class Collection
 * @package Inchoo\CustomerTicket\Model\ResourceModel\Reply
 */
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    protected function _construct()
    {
        $this->_init(
          \Inchoo\CustomerTicket\Model\Reply::class,
          \Inchoo\CustomerTicket\Model\ResourceModel\Reply::class
        );
    }

}