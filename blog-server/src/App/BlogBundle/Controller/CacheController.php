<?php

namespace App\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Response;

class CacheController extends Controller
{
    /**
     * Clear all cache.
     *
     * @ApiDoc(
     *   section = "Cache",
     *   resource = true
     * )
     *
     * @Method("POST")
     * @Route("api/cache/clear")
     *
     * @return JsonResponse
     */
    public function deleteAllCache()
    {
        $this->get('cache_redis')->deleteAllCache();

        return JsonResponse::create(['message' => sprintf('Cache clear.')], Response::HTTP_OK);
    }
}