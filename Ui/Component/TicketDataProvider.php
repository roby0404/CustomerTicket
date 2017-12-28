<?php

namespace Inchoo\CustomerTicket\Ui\Component;

/**
 * Class TicketDataProvider
 * @package Inchoo\CustomerTicket\Ui\Component
 */
class TicketDataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{

    /**
     * @var \Inchoo\CustomerTicket\Model\ResourceModel\Ticket\Collection
     */
    protected $collection;

    /**
     * @var \Magento\Customer\Api\CustomerRepositoryInterface
     */
    protected $customerRepository;

    /**
     * @var \Magento\Framework\App\Request\DataPersistorInterface
     */
    protected $persistor;

    /**
     * TicketDataProvider constructor.
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param \Inchoo\CustomerTicket\Model\ResourceModel\Ticket\CollectionFactory $collectionFactory
     * @param \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository
     * @param \Magento\Framework\App\Request\DataPersistorInterface $persistor
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        \Inchoo\CustomerTicket\Model\ResourceModel\Ticket\CollectionFactory $collectionFactory,
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository,
        \Magento\Framework\App\Request\DataPersistorInterface $persistor,
        array $meta = [],
        array $data = []
    )
    {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $collectionFactory->create();
        $this->customerRepository = $customerRepository;
        $this->persistor = $persistor;
    }

    /**
     * @return array
     */
    public function getData()
    {
        $dataObject = $this->getCollection()->getFirstItem();

        $ticket = $dataObject->toArray();

        $customer = $this->customerRepository->getById($ticket['customer_id']);

        $ticket['customer_name'] = $customer->getFirstname();
        $ticket['customer_email'] = $customer->getEmail();
        $ticket['reply_message'] = '';

        $this->persistor->set('ticket_id', $dataObject->getId());

        $data = [
            $dataObject->getId() => $ticket
        ];

        return $data;
    }

}