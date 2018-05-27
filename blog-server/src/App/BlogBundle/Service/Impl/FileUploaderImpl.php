<?php

namespace App\BlogBundle\Service\Impl;

use App\BlogBundle\Service\FileUploader;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploaderImpl implements FileUploader
{
    private $targetDir;

    public function __construct($targetDir)
    {
        $this->targetDir = $targetDir;
    }

    public function upload($data)
    {
        file_put_contents($this->getTargetDir() . $data['filename'],  base64_decode($data['value']));

        return $data['filename'];
    }

    public function getTargetDir()
    {
        return $this->targetDir;
    }
}