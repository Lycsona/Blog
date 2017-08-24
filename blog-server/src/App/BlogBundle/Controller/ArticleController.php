<?php

namespace App\BlogBundle\Controller;

use App\BlogBundle\AppBlogBundleEvents;
use App\BlogBundle\Event\ApiExceptionEvent;
use App\BlogBundle\Factory\ModelFactory;
use App\BlogBundle\Form\ArticleType;
use App\BlogBundle\DTO\ArticleDTO;
use App\BlogBundle\Entity\Article;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
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
     * @Route("api/articles", name="get_articles")
     * @Method("GET")
     *
     * @return JsonResponse
     */
    public function getAllArticleAction()
    {
        $entityManager = $this->getDoctrine()->getManager();

        $entities = $entityManager->getRepository(Article::class)->findAll();
        $articles = $this->get('serializer')->serialize(
            $entities,
            'json'
        );

        return JsonResponse::fromJsonString($articles, Response::HTTP_OK);
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
        $entityManager = $this->getDoctrine()->getManager();

        $entity = $entityManager->getRepository(Article::class)->find($id);
        if (!$entity) {
            $dispatcher = $this->get('event_dispatcher');
            $event = new ApiExceptionEvent($id, Response::HTTP_NOT_FOUND);

            $dispatcher->dispatch(AppBlogBundleEvents::GET_ENTITY_ERROR, $event);
        }

        $entityJson = $this->get('serializer')->serialize(
            $entity,
            'json'
        );

        return JsonResponse::fromJsonString($entityJson, Response::HTTP_OK);
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
        $articleDTO = ModelFactory::createArticle(new ArticleDTO());

        $form = $this->createForm(ArticleType::class, $articleDTO);
        $form->handleRequest($request);
        if (!$form->isSubmitted()) {
            return JsonResponse::create([
                'message' => sprintf('Error saving.'),
                'errors' => $this->getErrorsAsArray($form)
            ], Response::HTTP_BAD_REQUEST);
        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($articleDTO);
        $entityManager->flush();

        return JsonResponse::create(['message' => sprintf('Article created.')], Response::HTTP_CREATED);
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
        $entityManager = $this->getDoctrine()->getManager();

        $entity = $entityManager->getRepository(Article::class)->find($id);
        if (!$entity) {
            $dispatcher = $this->get('event_dispatcher');
            $event = new ApiExceptionEvent($id, Response::HTTP_NOT_FOUND);

            $dispatcher->dispatch(AppBlogBundleEvents::GET_ENTITY_ERROR, $event);
        }

        $form = $this->createForm(ArticleType::class, $entity, array('method' => 'PUT'));
        $form->handleRequest($request);
        if (!$form->isSubmitted()) {
            return JsonResponse::create([
                'message' => sprintf('Error updating.'),
                'errors' => $this->getErrorsAsArray($form)
            ], Response::HTTP_BAD_REQUEST);
        }
        $entityManager->persist($entity);
        $entityManager->flush();

        return JsonResponse::create([
            'message' => sprintf('Article updated.')],
            Response::HTTP_OK);
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
        $entityManager = $this->getDoctrine()->getManager();

        $entity = $entityManager->getRepository(Article::class)->find($id);
        if (!$entity) {

            $dispatcher = $this->get('event_dispatcher');
            $event = new ApiExceptionEvent($id, Response::HTTP_NOT_FOUND);

            $dispatcher->dispatch(AppBlogBundleEvents::GET_ENTITY_ERROR, $event);
        }

        $entityManager->remove($entity);
        $entityManager->flush();

        return JsonResponse::create([
            'message' => sprintf('Article deleted.'),
            Response::HTTP_OK]);

    }

    /**
     * Get error array.
     *
     * @param Form $form
     * @return array
     */
    private function getErrorsAsArray(Form $form)
    {
        $errors = array();

        foreach ($form->getErrors() as $error) {
            $errors[] = $error->getMessage();
        }

        foreach ($form->all() as $key => $child) {
            if ($err = $this->getErrorsAsArray($child)) {
                $errors[$key] = $err;
            }
        }

        return $errors;
    }
}