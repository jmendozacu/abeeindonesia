<?php

namespace Sams\Address\Setup;
use Magento\Framework\Setup\InstallSchemaInterface as InstallSchemaInterfaceAlias;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UpgradeSchemaInterface;

/**
 * @codeCoverageIgnore
 */
class UpgradeSchema implements UpgradeSchemaInterface
{

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        if (version_compare($context->getVersion(), '0.4.0', '<')) {
            $installer = $setup;
            $installer->startSetup();

            $installer->getConnection()->addColumn(
                $installer->getTable('quote'),
                'delivery_date',
                [
                    'type' => 'text',
                    'nullable' => false,
                    'comment' => 'Delivery Date',
                ]
            );

            $installer->getConnection()->addColumn(
                $installer->getTable('sales_order'),
                'delivery_date',
                [
                    'type' => 'text',
                    'nullable' => false,
                    'comment' => 'Delivery Date',
                ]
            );

            $installer->getConnection()->addColumn(
                $installer->getTable('sales_order_grid'),
                'delivery_date',
                [
                    'type' => 'text',
                    'nullable' => false,
                    'comment' => 'Delivery Date',
                ]
            );
            $setup->endSetup();
        }
    }
}