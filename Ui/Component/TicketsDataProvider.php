<?php

namespace Inchoo\CustomerTicket\Ui\Component;

use Inchoo\CustomerTicket\Api\Data\TicketInterface;

/**
 * Class TicketsDataProvider
 * @package Inchoo\CustomerTicket\Ui\Component
 */
class TicketsDataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{

    /**
     * @var \Inchoo\CustomerTicket\Model\ResourceModel\Ticket\Collection
     */
    protected $collection;

    /**
     * @var \Inchoo\CustomerTicket\Api\TicketRepositoryInterface|TicketRepositoryInterface
     */
    protected $ticketRepository;

    /**
     * @var \Magento\Customer\Api\CustomerRepositoryInterface
     */
    protected $customerRepository;

    /**
     * TicketsDataProvider constructor.
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param \Inchoo\CustomerTicket\Model\ResourceModel\Ticket\CollectionFactory $ticketCollectionFactory
     * @param TicketRepositoryInterface $ticketRepository
     * @param \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        \Inchoo\CustomerTicket\Model\ResourceModel\Ticket\CollectionFactory $ticketCollectionFactory,
        \Inchoo\CustomerTicket\Api\TicketRepositoryInterface $ticketRepository,
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository,
        array $meta = [],
        array $data = []
    )
    {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $ticketCollectionFactory->create();
        $this->ticketRepository = $ticketRepository;
        $this->customerRepository = $customerRepository;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        $data = $this->getCollection()->setOrder('ticket_urgency')->setOrder('created_at')->toArray();

        $statusArray = array_flip(TicketInterface::TICKET_STATUS_ARRAY);

        usort($data['items'], function($a, $b) use (&$statusArray) {
            if($statusArray[$a['ticket_status']] == $statusArray[$b['ticket_status']]) {
                return 0;
            }
            return ($statusArray[$a['ticket_status']] < $statusArray[$b['ticket_status']]) ? -1 : 1;
        });

        foreach($data['items'] as $index => $item) {
            $data['items'][$index]['customer_name'] = $this->customerRepository->getById($item['customer_id'])->getFirstname();
            $data['items'][$index]['customer_email'] = $this->customerRepository->getById($item['customer_id'])->getEmail();
            $data['items'][$index]['ticket_urgency_indicator'] = TicketInterface::TICKET_URGENCY_LEVELS[$this->ticketRepository->getById($item['ticket_id'], $item['customer_id'])->getTicketUrgency()];
            $data['items'][$index]['ticket_status_state'] = ucfirst($item['ticket_status']);
        }

        return $data;
    }

}