<?php

namespace App\BlogBundle\Controller;

use PhpAmqpLib\Message\AMQPMessage;
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

    /**
     * @ApiDoc(
     *   section="PageViews",
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     *
     *
     * @Route("api/page-views-rq/{id}", name="page-views-rq")
     * @Method("GET")
     *
     * @param integer $id
     * @return JsonResponse
     */
    public function pageViewsRQFunction($id)
    {
        $message = new AMQPMessage($id);

        $this->get('old_sound_rabbit_mq.page_views_producer')->publish($message->getBody());

        return new JsonResponse($message->getBody(), 200);
    }

}