<?php

namespace Inchoo\CustomerTicket\Controller\Ticket;

use Inchoo\CustomerTicket\Api\Data\TicketInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class RequestReopen
 * @package Inchoo\CustomerTicket\Controller\Ticket
 */
class RequestReopen extends AbstractTicket
{

    /**
     * @var \Magento\Framework\App\Request\Http
     */
    protected $request;

    /**
     * @var \Inchoo\CustomerTicket\Api\TicketRepositoryInterface
     */
    protected $ticketRepository;

    /**
     * RequestReopen constructor.
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Framework\App\Request\Http $request
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Inchoo\CustomerTicket\Api\TicketRepositoryInterface $ticketRepository
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\App\Request\Http $request,
        \Magento\Customer\Model\Session $customerSession,
        \Inchoo\CustomerTicket\Api\TicketRepositoryInterface $ticketRepository
    )
    {
        $this->request = $request;
        $this->ticketRepository = $ticketRepository;
        parent::__construct($context, $ticketRepository, $customerSession);
    }

    /**
     * @return \Magento\Framework\Controller\Result\Redirect
     */
    public function execute()
    {
        try {
            $ticketId = $this->request->getParam(TicketInterface::TICKET_ID);
            $ticket = $this->_getTicket($ticketId);

            try {
                $this->ticketRepository->requestReopen($ticket);
            } catch (CouldNotSaveException $exception) {
                $this->messageManager->addErrorMessage('Ticket reopen request is not sent');
            }

        } catch (NoSuchEntityException $exception) {
           return $this->_redirectWithError();
        }

        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath(TicketInterface::TICKET_URL, [TicketInterface::TICKET_ID => $ticketId]);
        return $resultRedirect;
    }

}