<?php

namespace Inchoo\CustomerTicket\Ui\Component\Listing\Column;

/**
 * Class EditActions
 * @package Inchoo\CustomerTicket\Ui\Component\Listing\Column
 */
class EditActions extends \Magento\Ui\Component\Listing\Columns\Column
{

    /**
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if(!isset($dataSource['data']['items'])) {
            return $dataSource;
        }

        foreach($dataSource['data']['items'] as & $item) {
            if(isset($item['ticket_id'])) {
                $item[$this->getData('name')] = [
                    'view' => [
                        'href' => $this->context->getUrl(
                            'ticket/ticket/edit',
                            ['id' => $item['ticket_id']]
                        ),
                        'label' => __('View')
                    ]
                ];
            }
        }

        return $dataSource;
    }

}