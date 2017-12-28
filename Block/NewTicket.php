<?php

namespace Inchoo\CustomerTicket\Block;

use Inchoo\CustomerTicket\Api\Data\TicketInterface;

/**
 * Class NewTicket
 * @package Inchoo\CustomerTicket\Block
 */
class NewTicket extends \Magento\Framework\View\Element\Template
{

    /**
     * @var \Inchoo\CustomerTicket\Api\Data\UrgencyIndicatorConfigInterface
     */
    protected $urgencyConfig;

    /**
     * NewTicket constructor.
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Inchoo\CustomerTicket\Api\Data\UrgencyIndicatorConfigInterface $urgencyConfig
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Inchoo\CustomerTicket\Api\Data\UrgencyIndicatorConfigInterface $urgencyConfig,
        array $data = []
    )
    {
        $this->urgencyConfig = $urgencyConfig;
        parent::__construct($context, $data);
    }

    /**
     * @return string
     */
    public function getSubmitUrl()
    {
        return $this->getUrl(TicketInterface::SUBMIT_URL);
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return "New Ticket";
    }

    /**
     * @return mixed
     */
    public function isTicketUrgencyEnabled()
    {
        return $this->urgencyConfig->isEnabled();
    }

}