<?php

namespace Inchoo\CustomerTicket\Controller\Ticket;

use Inchoo\CustomerTicket\Api\Data\TicketInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class Close
 * @package Inchoo\CustomerTicket\Controller\Ticket
 */
class Close extends AbstractTicket
{

    /**
     * @var \Magento\Framework\App\Request\Http
     */
    protected $request;

    /**
     * @var \Inchoo\CustomerTicket\Model\TicketRepository
     */
    protected $ticketRepository;

    /**
     * Close constructor.
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Inchoo\CustomerTicket\Model\TicketRepository $ticketRepository
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Framework\App\Request\Http $request
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Inchoo\CustomerTicket\Model\TicketRepository $ticketRepository,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Framework\App\Request\Http $request
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
                $this->ticketRepository->close($ticket);
            } catch (CouldNotSaveException $exception) {
                $this->messageManager->addErrorMessage(__('Ticket is not closed'));
            }

        } catch (NoSuchEntityException $exception) {
            return $this->_redirectWithError();
        }

        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath(TicketInterface::TICKET_URL, [TicketInterface::TICKET_ID => $ticketId]);
        return $resultRedirect;
    }

}