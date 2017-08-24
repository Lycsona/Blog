<?php

namespace App\BlogBundle\Controller;

use App\BlogBundle\AppBlogBundleEvents;
use App\BlogBundle\DTO\TagDTO;
use App\BlogBundle\Entity\Tag;
use App\BlogBundle\Event\ApiExceptionEvent;
use App\BlogBundle\Factory\ModelFactory;
use App\BlogBundle\Form\TagType;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class TagController extends Controller
{
    /**
     * Lists of all Tag entities.
     *
     * @ApiDoc(
     *   section="Tag",
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     *
     * @Route("api/tags", name="get_tags")
     * @Method("GET")
     *
     * @return JsonResponse
     */
    public function getAllTagAction()
    {
        $entityManager = $this->getDoctrine()->getManager();

        $entities = $entityManager->getRepository(Tag::class)->findAll();
        $tags = $this->get('serializer')->serialize(
            $entities,
            'json'
        );

        return JsonResponse::fromJsonString($tags, Response::HTTP_OK);
    }

    /**
     * Finds Tag entity by id.
     *
     * @ApiDoc(
     *   section = "Tag",
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when such entry not found"
     *   }
     * )
     * @Method("GET")
     * @Route("api/tags/{id}", name="get_tag")
     * @param int $id
     *
     * @return JsonResponse
     */
    public function getTagByIdAction($id)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $entity = $entityManager->getRepository(Tag::class)->find($id);
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
     * Creates a new Tag entity.
     *
     * @ApiDoc(
     *   section="Tag",
     *   resource = true,
     *   input = {
     *      "class" = "App\BlogBundle\Form\TagType"
     *   },
     *   statusCodes = {
     *     201 = "Returned when successful",
     *     400 = "Returned when bed request"
     *   },
     * )
     *
     * @Route("api/tags", name="create_tag")
     * @Method({"POST"})
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function createTagAction(Request $request)
    {
        $tagDTO = ModelFactory::createTag(new TagDTO());

        $form = $this->createForm(TagType::class, $tagDTO);
        $form->handleRequest($request);
        if (!$form->isSubmitted()) {
            return JsonResponse::create([
                'message' => sprintf('Error saving.'),
                'errors' => $this->getErrorsAsArray($form)
            ], Response::HTTP_BAD_REQUEST);
        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($tagDTO);
        $entityManager->flush();

        return JsonResponse::create(['message' => sprintf('Tag created.')], Response::HTTP_CREATED);
    }

    /**
     * Edit an existing Tag entity.
     *
     * @ApiDoc(
     *   section = "Tag",
     *   resource = true,
     *   input = {
     *      "class" = "App\BlogBundle\Form\TagType"
     *   },
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     400 = "Returned when form data is not valid",
     *     404 = "Returned whe entry not found"
     *   }
     * )
     *
     * @Method("PUT")
     * @Route("api/tags/{id}", name="edit_tag")
     * @param Request $request
     * @param int $id
     *
     * @return  JsonResponse
     */
    public function editTagAction(Request $request, $id)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $entity = $entityManager->getRepository(Tag::class)->find($id);
        if (!$entity) {
            $dispatcher = $this->get('event_dispatcher');
            $event = new ApiExceptionEvent($id, Response::HTTP_NOT_FOUND);

            $dispatcher->dispatch(AppBlogBundleEvents::GET_ENTITY_ERROR, $event);
        }

        $form = $this->createForm(TagType::class, $entity, array('method' => 'PUT'));
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
            'message' => sprintf('Tag updated.')],
            Response::HTTP_OK);
    }

    /**
     * Deletes a Tag entity.
     *
     * @ApiDoc(
     *   section = "Tag",
     *   resource = true,
     *   statusCodes = {
     *     400 = "Returned when such entity not found",
     *     200 = "Successful, but there is no entity to be returned"
     *   }
     * )
     *
     * @Method("DELETE")
     * @Route("/api/tags/{id}", name="delete_tag")
     * @param int $id
     *
     * @return  JsonResponse
     */
    public function deleteTagAction($id)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $entity = $entityManager->getRepository(Tag::class)->find($id);
        if (!$entity) {
            $dispatcher = $this->get('event_dispatcher');
            $event = new ApiExceptionEvent($id, Response::HTTP_NOT_FOUND);

            $dispatcher->dispatch(AppBlogBundleEvents::GET_ENTITY_ERROR, $event);
        }

        $entityManager->remove($entity);
        $entityManager->flush();

        return JsonResponse::create([
            'message' => sprintf('Tag deleted.'),
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