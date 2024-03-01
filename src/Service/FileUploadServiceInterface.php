<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;

interface FileUploadServiceInterface { 
    public function upload(UploadedFile $uploadFile, string $path): File;
}