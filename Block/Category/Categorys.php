<?php

namespace Steampfli\Agenda\Block\Category;

use \Magento\Framework\View\Element\Template;
use \Magento\Framework\View\Element\Template\Context;
use Steampfli\Agenda\Model\ResourceModel\Category\Collection as CategoryCollection;
use Steampfli\Agenda\Model\ResourceModel\Category\CollectionFactory as CategoryCollectionFactory;
use \Steampfli\Agenda\Model\Category;

class Categorys extends Template
{
    /**
     * CollectionFactory
     * @var null|CollectionFactory
     */
    protected $_categoryCollectionFactory = null;

    /**
     * Constructor
     *
     * @param Context $context
     * @param CategoryCollectionFactory $categoryCollectionFactory
     * @param array $data
     */
    public function __construct(
        Context $context,
        CategoryCollectionFactory $categoryCollectionFactory,
        array $data = []
    ) {
        $this->_categoryCollectionFactory = $categoryCollectionFactory;
        parent::__construct($context, $data);
    }

    /**
     * @return Category[]
     */
    public function getCategories()
    {
        /** @var CategoryCollection $categoryCollection */
        $categoryCollection = $this->_categoryCollectionFactory->create();
        $categoryCollection->addFieldToSelect('*')->load();
        return $categoryCollection->getItems();
    }

    /**
     * For a given category, returns its url
     * @param Category $category
     * @return string
     */
    public function getCategoryUrl(Category $category)
    {
        return '/eavblog/category/view/id/' . $category->getId();
    }

}
