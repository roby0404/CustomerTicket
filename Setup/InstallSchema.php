<?php

namespace Inchoo\CustomerTicket\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

/**
 * Class InstallSchema
 * @package Inchoo\CustomerTicket\Setup
 */
class InstallSchema implements InstallSchemaInterface
{

    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        $ticketTable = $setup->getConnection()->newTable(
            $setup->getTable('customer_ticket')
        )->addColumn(
            'ticket_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
            'Ticket ID'
        )->addColumn(
            'customer_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            10,
            ['unsigned' => true, 'nullable' => false],
            'Customer ID'
        )->addColumn(
             'website_id',
             \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
             5,
            ['unsigned' => true, 'nullable' => false],
             'Website ID'
        )->addColumn(
            'ticket_subject',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            'Ticket subject'
        )->addColumn(
            'ticket_message',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            'Ticket message'
        )->addColumn(
            'ticket_status',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            50,
            ['nullable' => false],
            'Ticket status'
        )->addColumn(
            'created_at',
            \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
            'Ticket creation date'
        )->addColumn(
            'updated_at',
            \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT_UPDATE],
            'Ticket update date'
        )->addColumn(
            'ticket_urgency',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['nullable' => false, 'unsigned' => true, 'default' => 0],
            'Ticket urgency indicator'
        )->addForeignKey(
            $setup->getFkName(
                'customer_ticket',
                'customer_id',
                'customer_entity',
                'entity_id'
            ),
            'customer_id',
            'customer_entity',
            'entity_id',
            \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
        )->addForeignKey(
            $setup->getFkName(
                'customer_ticket',
                'website_id',
                'store_website',
                'website_id'
            ),
            'website_id',
            'store_website',
            'website_id',
            \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
        );

        $setup->getConnection()->createTable($ticketTable);

        $replyTable = $setup->getConnection()->newTable(
            $setup->getTable('customer_ticket_reply')
        )->addColumn(
            'reply_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
            'Reply ID'
        )->addColumn(
            'ticket_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['unsigned' => true, 'nullable' => false],
            'Ticket ID'
        )->addColumn(
            'reply_message',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            'Reply message'
        )->addColumn(
            'admin_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            10,
            ['unsigned' => true, 'default' => null],
            'If admin replies,Admin User ID is stored here'
        )->addColumn(
            'created_at',
            \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
            'Reply creation date'
        )->addForeignKey(
            $setup->getFkName(
                'customer_ticket_reply',
                'ticket_id',
                'customer_ticket',
                'ticket_id'
            ),
            'ticket_id',
            'customer_ticket',
            'ticket_id',
            \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
        )->addForeignKey(
            $setup->getFkName(
                'customer_ticket_reply',
                'admin_id',
                'admin_user',
                'user_id'
            ),
            'admin_id',
            'admin_user',
            'user_id',
            \Magento\Framework\DB\Ddl\Table::ACTION_NO_ACTION
        );

        $setup->getConnection()->createTable($replyTable);

        $setup->endSetup();
    }

}