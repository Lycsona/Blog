<?php

namespace App\BlogBundle\Controller;

use App\BlogBundle\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class PageViewsController extends Controller
{
    private function incrementPageViews(Article $article)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $pageViews = $article->getPageViews();
        $pageViews->setCounter($pageViews->getCounter() + 1);

        $entityManager->persist($pageViews);
        $entityManager->flush();
    }
}