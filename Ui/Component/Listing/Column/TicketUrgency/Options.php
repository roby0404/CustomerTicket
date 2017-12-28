<?php

namespace Inchoo\CustomerTicket\Ui\Component\Listing\Column\TicketUrgency;

/**
 * Class Options
 * @package Inchoo\CustomerTicket\Ui\Component\Listing\Column\TicketUrgency
 */
class Options implements \Magento\Framework\Data\OptionSourceInterface
{

    /**
     * @return array
     */
    public function toOptionArray()
    {
        return [
            [
                'label' => 'Not urgent',
                'value' => 0
            ],
            [
                'label' => 'Urgent',
                'value' => 1
            ],
            [
                'label' => 'Very urgent',
                'value' => 2
            ],
            [
                'label' => 'Critically urgent',
                'value' => 3
            ]
        ];
    }

}