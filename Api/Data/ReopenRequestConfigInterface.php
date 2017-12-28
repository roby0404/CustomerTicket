<?php

namespace Inchoo\CustomerTicket\Api\Data;

/**
 * Interface ReopenRequestConfigInterface
 * @package Inchoo\CustomerTicket\Api\Data
 */
interface ReopenRequestConfigInterface
{

    const XML_REOPEN_REQUEST_TEMPLATE = 'customer_ticket_configuration/requests/enable_ticket_reopen_requests';

    public function isEnabled();

}