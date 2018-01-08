<?php

namespace App\BlogBundle\RabbitMq\Consumer;

use App\BlogBundle\AppBlogBundleEvents;
use App\BlogBundle\Event\PageViewsEvent;
use App\BlogBundle\Service\Impl\PageViewsImpl;
use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;
use Symfony\Component\HttpKernel\Debug\TraceableEventDispatcher;


class PageViewsConsumer implements ConsumerInterface
{
    private $logger;

    private $dispatcher;

    private $pageViews;

    public function __construct(
        $logger,
        TraceableEventDispatcher $dispatcher,
        PageViewsImpl $pageViews
    )
    {
        $this->logger = $logger;
        $this->dispatcher = $dispatcher;
        $this->pageViews = $pageViews;
    }

    public function execute(AMQPMessage $msg)
    {
        $event = new PageViewsEvent($msg->body);
        $this->dispatcher->dispatch(AppBlogBundleEvents::PAGE_VIEW_EVENT, $event);
    }
}