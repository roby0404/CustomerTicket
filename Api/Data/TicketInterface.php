<?php

namespace Inchoo\CustomerTicket\Api\Data;

/**
 * Interface TicketInterface
 * @package Inchoo\CustomerTicket\Api\Data
 */
interface TicketInterface
{

    const TICKET_ID = 'ticket_id';

    const CUSTOMER_ID = 'customer_id';

    const WEBSITE_ID = 'website_id';

    const SUBJECT = 'ticket_subject';

    const MESSAGE = 'ticket_message';

    const STATUS = 'ticket_status';

    const CREATED_AT = 'created_at';

    const UPDATED_AT = 'updated_at';

    const FORM_URL = 'ticket/newticket';

    const SUBMIT_URL = 'ticket/newticket/saveticket';

    const TICKET_URL = 'ticket/ticket/index';

    const CUSTOMER_TICKETS_VIEW = 'ticket/mytickets/';

    const TICKET_URGENCY_LEVELS = [
        0 => 'Not urgent',
        1 => 'Urgent',
        2 => 'Very urgent',
        3 => 'Critically urgent'
    ];

    const TICKET_STATUS_ARRAY = [
        '0' => 'open',
        '1' => 'reopen requested',
        '2' => 'closed'
    ];

    /**
     * @param $customerId
     * @return mixed
     */
    public function confirmTicketOwnership($customerId);

}