<?php

namespace Inchoo\CustomerTicket\Api\Data;

/**
 * Interface UrgencyIndicatorConfigInterface
 * @package Inchoo\CustomerTicket\Api\Data
 */
interface UrgencyIndicatorConfigInterface
{

    const XML_URGENCY_INDICATOR_TEMPLATE = 'customer_ticket_configuration/ticket_configuration/enable_urgency_indicator';

    public function isEnabled();

}