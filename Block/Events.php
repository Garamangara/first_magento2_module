<?php

namespace Steampfli\Agenda\Block;

use \Magento\Framework\View\Element\Template;
use \Magento\Framework\View\Element\Template\Context;
use Steampfli\Agenda\Model\ResourceModel\Event\Collection as EventCollection;
use Steampfli\Agenda\Model\ResourceModel\Event\CollectionFactory as EventCollectionFactory;
use \Steampfli\Agenda\Model\Event;

class Events extends Template
{
    /**
     * CollectionFactory
     * @var null|CollectionFactory
     */
    protected $_eventCollectionFactory = null;

    /**
     * Constructor
     *
     * @param Context $context
     * @param EventCollectionFactory $eventCollectionFactory
     * @param array $data
     */
    public function __construct(
        Context $context,
        EventCollectionFactory $eventCollectionFactory,
        array $data = []
    ) {
        $this->_eventCollectionFactory = $eventCollectionFactory;
        parent::__construct($context, $data);
    }

    /**
     * @return Event[]
     */
    public function getEvents()
    {
        /** @var EventCollection $eventCollection */
        $eventCollection = $this->_eventCollectionFactory->create();
        $eventCollection->addFieldToSelect('*')->load();
        return $eventCollection->getItems();
    }

    /**
     * For a given event, returns its url
     * @param Event $event
     * @return string
     */
    public function getEventUrl(Event $event)
    {
        return '/eavblog/event/view/id/' . $event->getId();
    }

}
