<?php
/**
 * installSchema.php
 *
 * @copyright Copyright © 2020 Steampfli. All rights reserved.
 * @author    batontram@gmail.com
 */
namespace Steampfli\Agenda\Setup;

use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Steampfli\Agenda\Setup\EavTablesSetupFactory;

/**
 * @codeCoverageIgnore
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * @var EavTablesSetupFactory
     */
    protected $eavTablesSetupFactory;

    /**
     * Init
     *
     * @internal param EavTablesSetupFactory $EavTablesSetupFactory
     */
    public function __construct(EavTablesSetupFactory $eavTablesSetupFactory)
    {
        $this->eavTablesSetupFactory = $eavTablesSetupFactory;
    }

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context) //@codingStandardsIgnoreLine
    {
        $setup->startSetup();

        $tableCategory = CategorySetup::ENTITY_TYPE_CODE . '_entity';
        /**
         * Create Category entity Table
         */
        $table = $setup->getConnection()
            ->newTable($setup->getTable($tableCategory))
            ->addColumn(
                'entity_id',
                Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                'Entity ID'
            )->setComment('Entity Table');

        $table->addColumn(
            'identifier',
            Table::TYPE_TEXT,
            100,
            ['nullable' => false],
            'Identifier'
        )->addIndex(
            $setup->getIdxName($tableCategory, ['identifier']),
            ['identifier']
        );

        // Add more static attributes here...

        $table->addColumn(
            'created_at',
            Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false, 'default' => Table::TIMESTAMP_INIT],
            'Creation Time'
        )->addColumn(
            'updated_at',
            Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false, 'default' => Table::TIMESTAMP_INIT_UPDATE],
            'Update Time'
        );

        $setup->getConnection()->createTable($table);

        /** @var \Steampfli\Agenda\Setup\EavTablesSetup $eavTablesSetup */
        $eavTablesSetup = $this->eavTablesSetupFactory->create(['setup' => $setup]);
        $eavTablesSetup->createEavTables(CategorySetup::ENTITY_TYPE_CODE);

        /**
         * Create Event entity Table
         */
        $tableEvent = EventSetup::ENTITY_TYPE_CODE . '_entity';

        $table = $setup->getConnection()
            ->newTable($setup->getTable($tableEvent))
            ->addColumn(
                'entity_id',
                Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                'Entity ID'
            )->setComment('Entity Table');

        $table->addColumn(
            'identifier',
            Table::TYPE_TEXT,
            100,
            ['nullable' => false],
            'Identifier'
        )->addIndex(
            $setup->getIdxName($tableEvent, ['identifier']),
            ['identifier']
        );

        // Add more static attributes here...

        $table->addColumn(
            'created_at',
            Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false, 'default' => Table::TIMESTAMP_INIT],
            'Creation Time'
        )->addColumn(
            'updated_at',
            Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false, 'default' => Table::TIMESTAMP_INIT_UPDATE],
            'Update Time'
        );

        $setup->getConnection()->createTable($table);

        /** @var \Steampfli\Agenda\Setup\EavTablesSetup $eavTablesSetup */
        $eavTablesSetup = $this->eavTablesSetupFactory->create(['setup' => $setup]);
        $eavTablesSetup->createEavTables(EventSetup::ENTITY_TYPE_CODE);

        /**
         * Create many to many relation table.
         *
         * Event -> Category
         */

        $table = $setup->getConnection()
            ->newTable($setup->getTable('steampfli_event_category'))
            ->addColumn('category_id', Table::TYPE_INTEGER, null, [
                'unsigned' => true,
                'primary' => true,
                'nullable' => false
            ], 'Category ID')
            ->addColumn('event_id', Table::TYPE_INTEGER, null, [
                'unsigned' => true,
                'primary' => true,
                'nullable' => false
            ], 'Event ID')
            ->addColumn('position', Table::TYPE_INTEGER, null, [
                'nullable' => false,
                'default' => '0'
            ], 'Position')
            ->addIndex($setup->getIdxName('steampfli_event_category', ['category_id']), ['category_id'])
            ->addIndex($setup->getIdxName('steampfli_event_category', ['event_id']), ['event_id'])
            ->addForeignKey(
                $setup->getFkName(
                    'steampfli_event_category',
                    'category_id',
                    'steampfli_category_entity',
                    'entity_id'
                ),
                'category_id',
                $setup->getTable('steampfli_category_entity'),
                'entity_id',
                Table::ACTION_CASCADE
            )
            ->addForeignKey(
                $setup->getFkName(
                    'steampfli_event_category',
                    'event_id',
                    'steampfli_event_entity',
                    'entity_id'
                ),
                'event_id',
                $setup->getTable('steampfli_event_entity'),
                'entity_id',
                Table::ACTION_CASCADE
            )
            ->addIndex(
                $setup->getIdxName(
                    'steampfli_event_category',
                    ['category_id', 'event_id'],
                    AdapterInterface::INDEX_TYPE_UNIQUE
                ),
                ['category_id', 'event_id'],
                ['type' => AdapterInterface::INDEX_TYPE_UNIQUE]
            )
            ->setComment('Category To Event Link Table');

        $setup->getConnection()->createTable($table);


        $setup->endSetup();
    }
}
