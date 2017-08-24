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
            AppBlogBundleEvents::GET_ENTITY_ERROR => 'getEntity',
            AppBlogBundleEvents::CREATE_ENTITY_ERROR => 'createEntity',
            AppBlogBundleEvents::UPDATE_ENTITY_ERROR => 'createEntity',
            AppBlogBundleEvents::DELETE_ENTITY_ERROR => 'getEntity',
        ];
    }

    public function getEntity(ApiExceptionEvent $event)
    {
        $id = $event->getId();
        $statusCode = $event->getStatusCode();

        $event->setResponse(JsonResponse::fromJsonString(sprintf('There is no entity with id ' . $id), $statusCode));
    }

    public function createEntity(ApiExceptionEvent $event)
    {
        $errors = $event->getFormErrors($event->getForm());
        $statusCode = $event->getStatusCode();

        $event->setResponse(JsonResponse::create([
            'errors' => $errors
        ], $statusCode));
    }
}