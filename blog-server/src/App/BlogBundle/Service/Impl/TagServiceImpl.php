<?php

namespace App\BlogBundle\Service\Impl;

use App\BlogBundle\AppBlogBundleEvents;
use App\BlogBundle\DTO\TagDTO;
use App\BlogBundle\Entity\Tag;
use App\BlogBundle\Event\ApiExceptionEvent;
use App\BlogBundle\Factory\ModelFactory;
use App\BlogBundle\Form\TagType;
use App\BlogBundle\Service\TagsService;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Debug\TraceableEventDispatcher;
use Symfony\Component\Serializer\Serializer;

class TagServiceImpl implements TagsService
{
    private $em;

    private $formFactory;

    private $dispatcher;

    private $serializer;


    public function __construct(
        EntityManager $em,
        FormFactory $formFactory,
        TraceableEventDispatcher $dispatcher,
        Serializer $serializer
    )
    {
        $this->em = $em;
        $this->formFactory = $formFactory;
        $this->dispatcher = $dispatcher;
        $this->serializer = $serializer;
    }

    public function getTags()
    {
        $entities = $this->em->getRepository(Tag::class)->findAll();
        $tags = $this->serializer->serialize($entities, 'json');

        return JsonResponse::fromJsonString($tags, Response::HTTP_OK);
    }

    public function getTagById($id)
    {
        $entity = $this->em->getRepository(Tag::class)->find($id);
        if (!$entity) {
            $event = new ApiExceptionEvent(Response::HTTP_NOT_FOUND, ['id' => $id]);
            $this->dispatcher->dispatch(AppBlogBundleEvents::GET_ENTITY_ERROR, $event);

            return $event->getResponse();
        }

        $entityJson = $this->serializer->serialize($entity, 'json');

        return JsonResponse::fromJsonString($entityJson, Response::HTTP_OK);
    }

    public function createTag($request)
    {
        $tagDTO = ModelFactory::createTag(new TagDTO());

        $form = $this->formFactory->create(TagType::class, $tagDTO);
        $form->submit($request->request->all());
        if (!$form->isValid()) {
            $event = new ApiExceptionEvent(Response::HTTP_BAD_REQUEST, ['form' => $form]);
            $this->dispatcher->dispatch(AppBlogBundleEvents::CREATE_ENTITY_ERROR, $event);

            return $event->getResponse();
        }

        $this->em->persist($tagDTO);
        $this->em->flush();

        return JsonResponse::create(['message' => sprintf('Tag created.')], Response::HTTP_CREATED);
    }

    public function editTag($request, $id)
    {
        $entity = $this->em->getRepository(Tag::class)->find($id);
        if (!$entity) {
            $event = new ApiExceptionEvent(Response::HTTP_NOT_FOUND, ['id' => $id]);
            $this->dispatcher->dispatch(AppBlogBundleEvents::GET_ENTITY_ERROR, $event);

            return $event->getResponse();
        }

        $form = $this->formFactory->create(TagType::class, $entity, array('method' => 'PUT'));
        $form->submit($request->request->all());
        if (!$form->isValid()) {
            $event = new ApiExceptionEvent(Response::HTTP_BAD_REQUEST, ['form' => $form]);
            $this->dispatcher->dispatch(AppBlogBundleEvents::UPDATE_ENTITY_ERROR, $event);

            return $event->getResponse();
        }

        $this->em->persist($entity);
        $this->em->flush();

        return JsonResponse::create(['message' => sprintf('Tag updated.')], Response::HTTP_OK);
    }

    public function deleteTag($id)
    {
        $entity = $this->em->getRepository(Tag::class)->find($id);
        if (!$entity) {
            $event = new ApiExceptionEvent(Response::HTTP_NOT_FOUND, ['id' => $id]);
            $this->dispatcher->dispatch(AppBlogBundleEvents::DELETE_ENTITY_ERROR, $event);

            return $event->getResponse();
        }

        $this->em->remove($entity);
        $this->em->flush();

        return JsonResponse::create(['message' => sprintf('Tag deleted.'), Response::HTTP_OK]);
    }
}