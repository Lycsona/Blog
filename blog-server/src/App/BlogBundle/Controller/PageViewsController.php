<?php

namespace App\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

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
        return $this->get('page_views')->incrementPageViews($id);
    }
}