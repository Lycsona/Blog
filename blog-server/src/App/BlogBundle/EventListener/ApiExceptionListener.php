<?php

namespace App\BlogBundle\EventListener;

use App\BlogBundle\AppBlogBundleEvents;
use App\BlogBundle\Event\ApiExceptionEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class ApiExceptionListener implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            AppBlogBundleEvents::GET_ENTITY_ERROR => 'getEntity'
        ];
    }

    public function getEntity(ApiExceptionEvent $event)
    {
        $id = $event->getId();
        $statusCode = $event->getStatusCode();

        echo JsonResponse::fromJsonString(sprintf('There is no entity with id ' . $id), $statusCode);
    }
}