<?php

namespace Inchoo\CustomerTicket\Controller\Ticket;

use Inchoo\CustomerTicket\Api\Data\TicketInterface;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class AbstractTicket
 * @package Inchoo\CustomerTicket\Controller\Ticket
 */
abstract class AbstractTicket extends \Magento\Framework\App\Action\Action
{

    /**
     * @var \Inchoo\CustomerTicket\Api\TicketRepositoryInterface
     */
    protected $ticketRepository;

    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $customerSession;

    /**
     * AbstractTicket constructor.
     * @param Context $context
     * @param \Inchoo\CustomerTicket\Api\TicketRepositoryInterface $ticketRepository
     * @param \Magento\Customer\Model\Session $customerSession
     */
    public function __construct(
        Context $context,
        \Inchoo\CustomerTicket\Api\TicketRepositoryInterface $ticketRepository,
        \Magento\Customer\Model\Session $customerSession
    )
    {
        $this->ticketRepository = $ticketRepository;
        $this->customerSession = $customerSession;
        parent::__construct($context);
    }

    /**
     * @param $id
     * @return mixed
     * @throws NoSuchEntityException
     */
    protected function _getTicket($id)
    {
        $ticket = $this->ticketRepository->getById($id);

        if($ticket) {
            if(!$this->_validateTicket($ticket->getCustomerId())) {
                throw new NoSuchEntityException();
            }
            return $ticket;
        }
        throw new NoSuchEntityException();
    }

    /**
     * @param $customerId
     * @return bool
     */
    protected function _validateTicket($customerId)
    {
        if($customerId !== $this->customerSession->getCustomerId()) {
            return false;
        }
        return true;
    }

    /**
     * @return \Magento\Framework\Controller\Result\Redirect
     */
    protected function _redirectWithError()
    {
        $this->messageManager->addErrorMessage(__('Ticket not found'));
        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath(TicketInterface::CUSTOMER_TICKETS_VIEW);

        return $resultRedirect;
    }

    /**
     * @param RequestInterface $request
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Redirect
     */
    public function dispatch(RequestInterface $request)
    {
        if(!$this->customerSession->isLoggedIn()) {
            $resultRedirect = $this->resultRedirectFactory->create();
            $resultRedirect->setPath('customer/account/login');
            return $resultRedirect;
        }
        return parent::dispatch($request);
    }

}