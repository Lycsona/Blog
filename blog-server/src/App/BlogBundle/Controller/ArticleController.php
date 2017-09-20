<?php

namespace App\BlogBundle\Controller;

use App\BlogBundle\Entity\Article;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class ArticleController extends Controller
{
    /**
     * Lists of all Article entities.
     *
     * @ApiDoc(
     *   section="Article",
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     *
     * @Route("api/articles/page/{page}/size/{size}", name="get_articles")
     * @Method("GET")
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getAllArticleAction(Request $request)
    {
        $page = $request->get('page');
        $size = $request->get('size');

        return $this->get('article')->getArticles($page, $size);
    }

    /**
     * Finds Article entity by id.
     *
     * @ApiDoc(
     *   section = "Article",
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when such entry not found"
     *   }
     * )
     * @Method("GET")
     * @Route("api/articles/{id}", name="get_article")
     * @param int $id
     *
     * @return JsonResponse
     */
    public function getArticleByIdAction($id)
    {
        return $this->get('article')->getArticleById($id);
    }

    /**
     * Creates a new Article entity.
     *
     * @ApiDoc(
     *   section="Article",
     *   resource = true,
     *   input = {
     *      "class" = "App\BlogBundle\Form\ArticleType"
     *   },
     *   statusCodes = {
     *     201 = "Returned when successful",
     *     400 = "Returned when bed request"
     *   },
     * )
     *
     * @Route("api/articles", name="create_article")
     * @Method({"POST"})
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function createArticleAction(Request $request)
    {
        return $this->get('article')->createArticle($request);
    }

    /**
     * Edit an existing Article entity.
     *
     * @ApiDoc(
     *   section = "Article",
     *   resource = true,
     *   input = {
     *      "class" = "App\BlogBundle\Form\ArticleType"
     *   },
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     400 = "Returned when form data is not valid",
     *     404 = "Returned whe entry not found"
     *   }
     * )
     *
     * @Method("PUT")
     * @Route("api/articles/{id}", name="edit_article")
     * @param Request $request
     * @param int $id
     *
     * @return  JsonResponse
     */
    public function editArticleAction(Request $request, $id)
    {
        return $this->get('article')->editArticle($request, $id);
    }

    /**
     * Deletes a Article entity.
     *
     * @ApiDoc(
     *   section = "Article",
     *   resource = true,
     *   statusCodes = {
     *     400 = "Returned when such entity not found",
     *     200 = "Successful, but there is no entity to be returned"
     *   }
     * )
     *
     * @Method("DELETE")
     * @Route("/api/articles/{id}", name="delete_article")
     * @param int $id
     *
     * @return  JsonResponse
     */
    public function deleteArticleAction($id)
    {
        return $this->get('article')->deleteArticle($id);
    }

    /**
     * Get all articles by tag.
     *
     * @ApiDoc(
     *   section = "Article",
     *   resource = true
     * )
     *
     * @Method("GET")
     * @Route("api/articles/tag/{tag}")
     * @param $tag
     * @return JsonResponse
     */
    public function getArticlesByTagAction($tag)
    {
        return $this->get('article')->getArticlesByTag($tag);
    }
}