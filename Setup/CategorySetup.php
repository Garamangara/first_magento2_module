<?php
/**
 * CategorySetup
 *
 * @copyright Copyright © 2020 Steampfli. All rights reserved.
 * @author    batontram@gmail.com
 */

namespace Steampfli\Agenda\Setup;

use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Eav\Setup\EavSetup;

/**
 * @codeCoverageIgnore
 */
class CategorySetup extends EavSetup
{
    /**
     * Entity type for Category EAV attributes
     */
    const ENTITY_TYPE_CODE = 'steampfli_category';

    /**
     * Retrieve Entity Attributes
     *
     * @return array
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    protected function getAttributes()
    {
        $attributes = [];

        $attributes['identifier'] = [
            'type' => 'static',
            'label' => 'identifier',
            'input' => 'text',
            'required' => true,
            'sort_order' => 10,
            'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
            'group' => 'General',
            'validate_rules' => 'a:2:{s:15:"max_text_length";i:100;s:15:"min_text_length";i:1;}'
        ];

        // Add your entity attributes here... For example:
        $attributes['is_active'] = [
            'type' => 'int',
            'label' => 'Is Active',
            'input' => 'select',
            'source' => 'Magento\Eav\Model\Entity\Attribute\Source\Boolean',
            'sort_order' => 10,
            'global' => ScopedAttributeInterface::SCOPE_STORE,
            'group' => 'General',
        ];

        $attributes['title'] = [
            'type' => 'varchar',
            'label' => 'Title',
            'input' => 'text',
            'required' => true, //true/false
            'sort_order' => 20,
            'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
            'group' => 'General',
            //'validate_rules' => 'a:2:{s:15:"max_text_length";i:255;s:15:"min_text_length";i:1;}',
        ];

        $attributes['description'] = [
            'type' => 'text',
            'label' => 'Description',
            'input' => 'textarea',
            'required' => true, //true/false
            'sort_order' => 30,
            'global' => ScopedAttributeInterface::SCOPE_STORE,
            'group' => 'General',
            'wysiwyg_enabled' => true,
        ];

        return $attributes;
    }

    /**
     * Retrieve default entities: category
     *
     * @return array
     */
    public function getDefaultEntities()
    {
        $entities = [
            self::ENTITY_TYPE_CODE => [
                'entity_model' => 'Steampfli\Agenda\Model\ResourceModel\Category',
                'attribute_model' => 'Steampfli\Agenda\Model\ResourceModel\Eav\Attribute',
                'table' => self::ENTITY_TYPE_CODE . '_entity',
                'increment_model' => null,
                'additional_attribute_table' => self::ENTITY_TYPE_CODE . '_eav_attribute',
                'entity_attribute_collection' => 'Steampfli\Agenda\Model\ResourceModel\Attribute\Collection',
                'attributes' => $this->getAttributes()
            ]
        ];

        return $entities;
    }
}
