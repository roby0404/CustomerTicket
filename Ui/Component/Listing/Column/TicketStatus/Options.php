<?php

namespace Inchoo\CustomerTicket\Ui\Component\Listing\Column\TicketStatus;

/**
 * Class Options
 * @package Inchoo\CustomerTicket\Ui\Component\Listing\Column\TicketStatus
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
              'label' => 'Open',
              'value' => 'open'
          ],
          [
              'label' => 'Closed',
              'value' => 'closed'
          ],
          [
              'label' => 'Reopen requested',
              'value' => 'reopen requested'
          ]
        ];
    }

}