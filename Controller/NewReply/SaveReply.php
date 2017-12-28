<?php

namespace Inchoo\CustomerTicket\Controller\NewReply;

use Inchoo\CustomerTicket\Api\Data\ReplyInterface;
use Inchoo\CustomerTicket\Api\ReplyRepositoryInterface;

class SaveReply extends \Magento\Framework\App\Action\Action
{

    /**
     * @var \Magento\Framework\App\Request\Http
     */
    protected $request;

    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $customerSession;

    /**
     * @var \Inchoo\CustomerTicket\Api\Data\ReplyInterfaceFactory
     */
    protected $replyFactory;

    /**
     * @var \Inchoo\CustomerTicket\Api\TicketRepositoryInterface
     */
    protected $ticketRepository;

    /**
     * @var \Inchoo\CustomerTicket\Api\ReplyRepositoryInterface
     */
    protected $replyRepository;

    /**
     * @var \Magento\Framework\App\Action\Context
     */
    protected $context;

    /**
     * SaveReply constructor.
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
        $this->customerSession = $customerSession;
        $this->replyFactory = $replyFactory;
        $this->ticketRepository = $ticketRepository;
        $this->replyRepository = $replyRepository;
        parent::__construct($context);
        $this->context = $context;
    }

    public function execute()
    {
        if(!$this->customerSession->isLoggedIn() || !$this->ticketRepository->getById($this->request->getParam(ReplyInterface::TICKET_ID), $this->customerSession->getCustomer()->getId())) {
            $this->_redirect('/');
        }
        $data = $this->request->getPostValue();
        $reply = $this->replyFactory->create();

        $reply->setTicketId($this->request->getParam(ReplyInterface::TICKET_ID));
        $reply->setReplyMessage($data['reply']);

        $this->replyRepository->save($reply);

        $this->_redirect($this->context->getUrl()->getUrl(ReplyInterface::TICKET_URL, ['id' => $this->request->getParam(ReplyInterface::TICKET_ID)]));
    }

}