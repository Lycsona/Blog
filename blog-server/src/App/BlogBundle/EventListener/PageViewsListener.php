<?php

namespace App\BlogBundle\EventListener;

use App\BlogBundle\AppBlogBundleEvents;
use App\BlogBundle\Event\PageViewsEvent;
use App\BlogBundle\Service\PageViewsService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class PageViewsListener implements EventSubscriberInterface
{
    private $pageViews;

    private $logger;

    public function __construct(
        PageViewsService $pageViews,
        $logger)
    {
        $this->pageViews = $pageViews;
        $this->logger = $logger;
    }

    public static function getSubscribedEvents()
    {
        return [
            AppBlogBundleEvents::PAGE_VIEW_EVENT => 'setIncrementPageViews'
        ];
    }

    public function setIncrementPageViews(PageViewsEvent $event)
    {
        $id = $event->getPageViewsId();

        $this->logger->info('Page was read with id = ' . $id);

        $this->pageViews->incrementPageViews($id);
    }
}