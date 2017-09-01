<?php

namespace App\BlogBundle\Controller;

use App\BlogBundle\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class PageViewsController extends Controller
{
    /**
     * Increment PageViews.
     *
     * @ApiDoc(
     *   section = "PageViews",
     *   resource = true
     * )
     *
     * @Method("POST")
     * @Route("api/page-views/{id}")
     * @param integer $id
     *
     * @return JsonResponse
     */
    public function incrementPageViews($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $article = $entityManager->getRepository(Article::class)->find($id);

        $pageViews = $article->getPageViews();
        $pageViews->setCounter($pageViews->getCounter() + 1);

        $entityManager->persist($pageViews);
        $entityManager->flush();

        $pageViewsJson = $this->get('serializer')->serialize(
            $pageViews,
            'json'
        );

        return JsonResponse::fromJsonString($pageViewsJson, Response::HTTP_OK);
    }
}