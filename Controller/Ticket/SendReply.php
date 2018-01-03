<?php

namespace Inchoo\CustomerTicket\Controller\Ticket;

use Inchoo\CustomerTicket\Api\Data\ReplyInterface;
use Inchoo\CustomerTicket\Api\ReplyRepositoryInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

class SendReply extends AbstractTicket
{

    /**
     * @var \Magento\Framework\App\Request\Http
     */
    protected $request;

    /**
     * @var \Inchoo\CustomerTicket\Api\Data\ReplyInterfaceFactory
     */
    protected $replyFactory;

    /**
     * @var \Inchoo\CustomerTicket\Api\ReplyRepositoryInterface
     */
    protected $replyRepository;

    /**
     * SendReply constructor.
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Framework\App\Request\Http $request
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Inchoo\CustomerTicket\Api\Data\ReplyInterfaceFactory $replyFactory
     * @param \Inchoo\CustomerTicket\Api\TicketRepositoryInterface $ticketRepository
     * @param ReplyRepositoryInterface $replyRepository
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\App\Request\Http $request,
        \Magento\Customer\Model\Session $customerSession,
        \Inchoo\CustomerTicket\Api\Data\ReplyInterfaceFactory $replyFactory,
        \Inchoo\CustomerTicket\Api\TicketRepositoryInterface $ticketRepository,
        \Inchoo\CustomerTicket\Api\ReplyRepositoryInterface $replyRepository
    )
    {
        $this->request = $request;
        $this->replyFactory = $replyFactory;
        $this->replyRepository = $replyRepository;
        parent::__construct($context, $ticketRepository, $customerSession);
    }

    /**
     * @return \Magento\Framework\Controller\Result\Redirect
     */
    public function execute()
    {
        try {
            $ticketId = $this->request->getParam(ReplyInterface::TICKET_ID);
            $this->_getTicket($ticketId);

            $data = $this->request->getPostValue();
            $reply = $this->replyFactory->create();

            $reply->setTicketId($this->request->getParam(ReplyInterface::TICKET_ID));
            $reply->setReplyMessage($data['reply']);

            try {
                $this->replyRepository->save($reply);
                $this->messageManager->addSuccessMessage(__('Reply sent successfully'));
            } catch (CouldNotSaveException $exception) {
                $this->messageManager->addErrorMessage(__('Reply is not sent'));
            }

        } catch (NoSuchEntityException $exception) {
            return $this->_redirectWithError();
        }

        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath(ReplyInterface::TICKET_URL, [ReplyInterface::TICKET_ID => $ticketId]);
        return $resultRedirect;
    }

}