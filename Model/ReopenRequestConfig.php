<?php

namespace Inchoo\CustomerTicket\Model;

use Inchoo\CustomerTicket\Api\Data\ReopenRequestConfigInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

/**
 * Class ReopenRequestConfig
 * @package Inchoo\CustomerTicket\Model
 */
class ReopenRequestConfig implements ReopenRequestConfigInterface
{

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * ReopenRequestConfig constructor.
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @return mixed
     */
    public function isEnabled()
    {
        return $this->scopeConfig->getValue(
          ReopenRequestConfigInterface::XML_REOPEN_REQUEST_TEMPLATE,
          ScopeInterface::SCOPE_STORE
        );
    }

}