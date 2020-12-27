<?php

namespace Steampfli\Agenda\Block;

use \Magento\Framework\Exception\LocalizedException;
use \Magento\Framework\View\Element\Template;
use \Magento\Framework\View\Element\Template\Context;
use \Magento\Framework\Registry;
use \Steampfli\Agenda\Model\Event;
use \Steampfli\Agenda\Model\EventFactory;
use \Steampfli\Agenda\Controller\Event\View as ViewAction;

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
     * Constructor
     * @param Context $context
     * @param Registry $coreRegistry
     * @param EventFactory $eventCollectionFactory
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        EventFactory $eventFactory,
        array $data = []
    ) {
        $this->_eventFactory = $eventFactory;
        $this->_coreRegistry = $coreRegistry;
        parent::__construct($context, $data);
    }

    /**
     * Lazy loads the requested event
     * @return Event
     * @throws LocalizedException
     */
    public function getEvent()
    {
        if ($this->_event === null) {
            /** @var Event $event */
            $event = $this->_eventFactory->create();
            $event->load($this->_getEventId());

            if (!$event->getId()) {
                throw new LocalizedException(__('Event not found'));
            }

            $this->_event = $event;
        }
        return $this->_event;
    }

    /**
     * Retrieves the event id from the registry
     * @return int
     */
    protected function _getEventId()
    {
        return (int) $this->_coreRegistry->registry(
            ViewAction::REGISTRY_KEY_POST_ID
        );
    }
}
