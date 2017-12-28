<?php

namespace Inchoo\CustomerTicket\Block\Adminhtml\Ticket;

/**
 * Class Reopen
 * @package Inchoo\CustomerTicket\Block\Adminhtml\Ticket
 */
class Reopen implements \Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface
{

    /**
     * @var \Magento\Framework\View\Element\UiComponent\Context
     */
    protected $context;

    /**
     * @var \Magento\Framework\App\Request\Http
     */
    protected $request;

    /**
     * @var \Inchoo\CustomerTicket\Api\TicketRepositoryInterface
     */
    protected $ticketRepository;

    /**
     * Reopen constructor.
     * @param \Magento\Framework\View\Element\UiComponent\Context $context
     * @param \Magento\Framework\App\Request\Http $request
     * @param \Inchoo\CustomerTicket\Api\TicketRepositoryInterface $ticketRepository
     */
    public function __construct(
        \Magento\Framework\View\Element\UiComponent\Context $context,
        \Magento\Framework\App\Request\Http $request,
        \Inchoo\CustomerTicket\Api\TicketRepositoryInterface $ticketRepository
    )
    {
        $this->context = $context;
        $this->request = $request;
        $this->ticketRepository = $ticketRepository;
    }

    /**
     * @return array
     */
    public function getButtonData()
    {
        $data = [];

        if($this->ticketRepository->isReopenRequested($this->request->getParam('id'))) {
            return [
              'label' => __('Reopen ticket'),
              'on_click' => sprintf("location.href = '%s'", $this->context->getUrl('ticket/ticket/reopen', ['ticket_id' => $this->request->getParam('id')]))
            ];
        }

        return $data;
    }

}