<?php

namespace App\BlogBundle\RabbitMq\Consumer;

use App\BlogBundle\AppBlogBundleEvents;
use App\BlogBundle\Event\IncorrectLoginEvent;
use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;
use Symfony\Component\HttpKernel\Debug\TraceableEventDispatcher;


class IncorrectLoginConsumer implements ConsumerInterface
{
    private $logger;

    private $dispatcher;


    public function __construct(
        $logger,
        TraceableEventDispatcher $dispatcher
    )
    {
        $this->logger = $logger;
        $this->dispatcher = $dispatcher;
    }

    public function execute(AMQPMessage $msg)
    {
        $event = new IncorrectLoginEvent($msg->getBody());
        $this->dispatcher->dispatch(AppBlogBundleEvents::INCORRECT_LOGIN_EVENT, $event);
    }
}