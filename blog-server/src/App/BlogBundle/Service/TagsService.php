<?php

namespace App\BlogBundle\Service;

interface TagsService
{
    public function getTags();

    public function getTagById($id);

    public function createTag($request);

    public function editTag($request, $id);

    public function deleteTag($id);
}