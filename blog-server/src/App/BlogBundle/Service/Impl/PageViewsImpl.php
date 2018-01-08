<?php

namespace App\BlogBundle\Service\Impl;

use App\BlogBundle\Entity\Article;
use App\BlogBundle\Service\PageViewsService;
use Doctrine\ORM\EntityManager;
use PhpAmqpLib\Message\AMQPMessage;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Serializer;

class PageViewsImpl implements PageViewsService
{
    private $em;

    private $serializer;

    private $rabbitMq;

    public function __construct(
        EntityManager $em,
        Serializer $serializer,
        $rabbitMq
    )
    {
        $this->em = $em;
        $this->serializer = $serializer;
        $this->rabbitMq = $rabbitMq;
    }

    public function incrementPageViews($id)
    {
        $article = $this->em->getRepository(Article::class)->find($id);

        $pageViews = $article->getPageViews();
        $pageViews->setCounter($pageViews->getCounter() + 1);

        $this->em->persist($pageViews);
        $this->em->flush();

        $pageViewsJson = $this->serializer->serialize(
            $pageViews,
            'json'
        );

        return JsonResponse::fromJsonString($pageViewsJson, Response::HTTP_OK);
    }

    public function incrementPageViewsWithRQ($id)
    {
        $message = new AMQPMessage($id);

        $this->rabbitMq->publish($message->getBody());

        return new JsonResponse($message->getBody(), 200);
    }
}