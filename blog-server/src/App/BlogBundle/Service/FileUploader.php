<?php

namespace App\BlogBundle\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;

interface FileUploader
{
    public function upload(UploadedFile $file);
}