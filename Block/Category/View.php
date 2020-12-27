<?php

namespace Steampfli\Agenda\Block\Category;

use \Magento\Framework\Exception\LocalizedException;
use \Magento\Framework\View\Element\Template;
use \Magento\Framework\View\Element\Template\Context;
use \Magento\Framework\Registry;
//use \Steampfli\Agenda\Model\Event;
//use \Steampfli\Agenda\Model\EventFactory;

use Steampfli\Agenda\Model\ResourceModel\Event\CollectionFactory as EventCollectionFactory;

use \Steampfli\Agenda\Model\Category;
use \Steampfli\Agenda\Model\CategoryFactory;
use \Steampfli\Agenda\Controller\Category\View as CategoryViewAction;
use Steampfli\Agenda\Model\ResourceModel\Event\Collection as EventCollection;

class View extends Template
{
    /**
     * Core registry
     * @var Registry
     */
    protected $_coreRegistry;

    /**
     * Event
     * @var null|Event
     */
    protected $_event = null;

    /**
     * EventFactory
     * @var null|EventFactory
     */
    protected $_eventFactory = null;

    /**
     * Category
     * @var null|Category
     */
    protected $_category = null;

    /**
     * CategoryFactory
     * @var null|CategoryFactory
     */
    protected $_categoryFactory = null;

//    /**
//     * CollectionFactory
//     * @var null|EventCollectionFactory
//     */
//    protected $_eventCollectionFactory = null;

    /**
     * View constructor.
     * @param Context $context
     * @param Registry $coreRegistry
     * @param CategoryFactory $categoryFactory
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
//        EventCollectionFactory $eventCollectionFactory,
        CategoryFactory $categoryFactory,
        array $data = []
    ) {
//        $this->_eventCollectionFactory = $eventCollectionFactory;
        $this->_categoryFactory = $categoryFactory;
        $this->_coreRegistry = $coreRegistry;
        parent::__construct($context, $data);
    }

    /**
     * Lazy loads the requested event
     * @return Category
     * @throws LocalizedException
     */
    public function getCategory()
    {
        if ($this->_category === null) {
            /** @var Category $category */
            $category = $this->_categoryFactory->create();
            $category->load($this->_getCategoryId());

            if (!$category->getId()) {
                throw new LocalizedException(__('Category not found'));
            }

            $this->_category = $category;
        }
        return $this->_category;
    }

    //1) получить id постов (массив)

    //перебирать массив id и в цикле выполнять функцию 2

    //2)
//    public function getEvents($eventId)
//    {
//        /** @var EventCollection $eventCollection */
//        $eventCollection = $this->_eventCollectionFactory->create();
//        // event_id или entity_id
//        $eventCollection->addFieldToFilter('event_id', $eventId)->load();
//        return $eventCollection->getItems();
//    }

    /**
     *
     * @return array
     */
    public function getPostsPosition()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance(); // Instance of object manager
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection();
        $eventCategory = $resource->getTableName('steampfli_event_category'); //gives table name with prefix
        $eventTable = $resource->getTableName('steampfli_event_entity');

        $sql = "select event_id from " . $eventCategory . " WHERE category_id = " . $this->_getCategoryId();
        $eventsIdArr = $connection->fetchCol($sql);

        $eventArr = [];

        foreach($eventsIdArr as $eventId) {
            $sql1 = "select * from " . $eventTable . " WHERE entity_id = " . $eventId;
            $eventArr[] = $connection->fetchAll($sql1);
        }

        return $eventArr;

    }

    /**
     * Retrieves the event id from the registry
     * @return int
     */
    protected function _getCategoryId()
    {
        return (int) $this->_coreRegistry->registry(
            CategoryViewAction::REGISTRY_KEY_POST_ID
        );
    }

    public function getCategoryEvents() {
        return 'Сделать коллекчию с определенными постами блога
        (понять реализацию на https://www.toptal.com/magento/magento-2-tutorial-building-a-complete-module )';
    }

}
