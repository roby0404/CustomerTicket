<?php

namespace Inchoo\CustomerTicket\Controller\Adminhtml\Ticket;

use Inchoo\CustomerTicket\Api\Data\TicketInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class Close
 * @package Inchoo\CustomerTicket\Controller\Adminhtml\Ticket
 */
class Close extends AbstractTicket
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
     * Close constructor.
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\App\Request\Http $request
     * @param \Inchoo\CustomerTicket\Api\TicketRepositoryInterface $ticketRepository
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\App\Request\Http $request,
        \Inchoo\CustomerTicket\Api\TicketRepositoryInterface $ticketRepository
    )
    {
        $this->request = $request;
        $this->ticketRepository = $ticketRepository;
        parent::__construct($context, $ticketRepository);
    }

    /**
     * @return \Magento\Framework\Controller\Result\Redirect
     */
    public function execute()
    {
        $ticketId = $this->request->getParam(TicketInterface::TICKET_ID);
        try {
            $ticket = $this->_getTicket($ticketId);

            try {
                $this->ticketRepository->close($ticket);
                $this->messageManager->addSuccessMessage(__('Ticket closed successfully'));
            } catch (CouldNotSaveException $exception) {
                $this->messageManager->addErrorMessage(__('Ticket could not be closed'));
            }

        } catch (NoSuchEntityException $exception) {
            return $this->_redirectWithError();
        }

        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath('*/*/edit', [TicketInterface::TICKET_ID => $ticketId]);
        return $resultRedirect;
    }

}