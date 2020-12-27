<?php

/**
 * Uninstall.php
 *
 * @copyright Copyright © 2020 Steampfli. All rights reserved.
 * @author    batontram@gmail.com
 */
namespace Steampfli\Agenda\Setup;

use Magento\Framework\Setup\UninstallInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

class Uninstall implements UninstallInterface
{
    /**
     * @var array
     */
    protected $tablesToUninstall = [
        CategorySetup::ENTITY_TYPE_CODE . '_entity',
        CategorySetup::ENTITY_TYPE_CODE . '_eav_attribute',
        CategorySetup::ENTITY_TYPE_CODE . '_entity_datetime',
        CategorySetup::ENTITY_TYPE_CODE . '_entity_decimal',
        CategorySetup::ENTITY_TYPE_CODE . '_entity_int',
        CategorySetup::ENTITY_TYPE_CODE . '_entity_text',
        CategorySetup::ENTITY_TYPE_CODE . '_entity_varchar',

        EventSetup::ENTITY_TYPE_CODE . '_entity',
        EventSetup::ENTITY_TYPE_CODE . '_eav_attribute',
        EventSetup::ENTITY_TYPE_CODE . '_entity_datetime',
        EventSetup::ENTITY_TYPE_CODE . '_entity_decimal',
        EventSetup::ENTITY_TYPE_CODE . '_entity_int',
        EventSetup::ENTITY_TYPE_CODE . '_entity_text',
        EventSetup::ENTITY_TYPE_CODE . '_entity_varchar',
    ];

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function uninstall(SchemaSetupInterface $setup, ModuleContextInterface $context) //@codingStandardsIgnoreLine
    {
        $setup->startSetup();

        foreach ($this->tablesToUninstall as $table) {
            if ($setup->tableExists($table)) {
                $setup->getConnection()->dropTable($setup->getTable($table));
            }
        }

        $setup->endSetup();
    }
}
