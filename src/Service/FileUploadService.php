<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\String\Slugger\SluggerInterface;

class FileUploadService implements FileUploadServiceInterface  { 

    public function __construct(
        private readonly SluggerInterface $slugger,
    ) {}

    public function upload(UploadedFile $uploadFile,string $path): File {
        $originalFilename = pathinfo($uploadFile->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $fileName = $safeFilename.'-'.uniqid().'.'.$uploadFile->guessExtension();
        $movedfile = $uploadFile->move($path,$fileName);
        return $movedfile;
    }
}