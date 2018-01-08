<?php

namespace App\BlogBundle\Service\Impl;

use App\BlogBundle\Entity\Article;
use App\BlogBundle\Service\PageViewsService;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\VarDumper\Exception\ThrowingCasterException;

class PageViewsImpl implements PageViewsService
{
    private $em;

    private $serializer;

    public function __construct(
        EntityManager $em,
        Serializer $serializer
    )
    {
        $this->em = $em;
        $this->serializer = $serializer;
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
}