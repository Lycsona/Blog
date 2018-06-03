<?php

namespace App\BlogBundle\Controller;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
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
        return $this->get('tag')->getTags();
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
        return $this->get('tag')->getTagById($id);
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
        return $this->get('tag')->createTag($request);
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
        return $this->get('tag')->editTag($request, $id);
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
        return $this->get('tag')->deleteTag($id);
    }
}