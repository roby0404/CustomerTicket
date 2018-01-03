<?php

namespace Inchoo\CustomerTicket\Controller\Adminhtml\Ticket;

use Inchoo\CustomerTicket\Api\Data\ReplyInterface;
use Magento\Framework\Exception\CouldNotSaveException;

/**
 * Class SendReply
 * @package Inchoo\CustomerTicket\Controller\Adminhtml\Ticket
 */
class SendReply extends \Magento\Backend\App\Action
{

    /**
     * @var \Magento\Backend\Model\Auth\Session
     */
    protected $authSession;

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
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Backend\Model\Auth\Session $authSession
     * @param \Inchoo\CustomerTicket\Api\Data\ReplyInterfaceFactory $replyFactory
     * @param \Inchoo\CustomerTicket\Api\ReplyRepositoryInterface $replyRepository
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Backend\Model\Auth\Session $authSession,
        \Inchoo\CustomerTicket\Api\Data\ReplyInterfaceFactory $replyFactory,
        \Inchoo\CustomerTicket\Api\ReplyRepositoryInterface $replyRepository
    )
    {
        $this->authSession = $authSession;
        $this->replyFactory = $replyFactory;
        $this->replyRepository = $replyRepository;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\Controller\Result\Redirect
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        $reply = $this->replyFactory->create();

        $reply->setTicketId($data['ticket_id']);
        $reply->setReplyMessage($data['reply_message']);
        $reply->setAdminId($this->authSession->getUser()->getId());

        try {
            $this->replyRepository->save($reply);
            $this->messageManager->addSuccessMessage(__('Replied successfully'));
        } catch (CouldNotSaveException $exception) {
            $this->messageManager->addErrorMessage(__('Reply not sent'));
        }

        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath('*/*/edit', [ReplyInterface::TICKET_ID => $data['ticket_id']]);
        return $resultRedirect;
    }

}