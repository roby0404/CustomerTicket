<?php

namespace Inchoo\CustomerTicket\Model;

use Inchoo\CustomerTicket\Api\Data\UrgencyIndicatorConfigInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

/**
 * Class UrgencyIndicatorConfig
 * @package Inchoo\CustomerTicket\Model
 */
class UrgencyIndicatorConfig implements UrgencyIndicatorConfigInterface
{

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * UrgencyIndicatorConfig constructor.
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
            UrgencyIndicatorConfigInterface::XML_URGENCY_INDICATOR_TEMPLATE,
            ScopeInterface::SCOPE_STORE
        );
    }

}