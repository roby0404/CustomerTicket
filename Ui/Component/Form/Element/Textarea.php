<?php

namespace Inchoo\CustomerTicket\Ui\Component\Form\Element;

use Inchoo\CustomerTicket\Api\Data\TicketInterface;

/**
 * Class Textarea
 * @package Inchoo\CustomerTicket\Ui\Component\Form\Element
 */
class Textarea extends \Magento\Ui\Component\Form\Element\Textarea
{

    /**
     * Textarea constructor.
     * @param \Magento\Framework\View\Element\UiComponent\ContextInterface $context
     * @param \Magento\Framework\App\Request\Http $request
     * @param \Inchoo\CustomerTicket\Api\TicketRepositoryInterface $ticketRepository
     * @param array $components
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\UiComponent\ContextInterface $context,
        \Magento\Framework\App\Request\Http $request,
        \Inchoo\CustomerTicket\Api\TicketRepositoryInterface $ticketRepository,
        array $components = [],
        array $data = []
    )
    {
        if($ticketRepository->isTicketClosed($request->getParam(TicketInterface::TICKET_ID))
            || $ticketRepository->isReopenRequested($request->getParam(TicketInterface::TICKET_ID))) {
            $data = [];
        }
        parent::__construct($context, $components, $data);
    }
}