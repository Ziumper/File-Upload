<?php

namespace App\Service;

use App\Dto\UploadEntryDto;
use App\Repository\UploadEntryRepositoryInterface;
use App\Entity\UploadEntry;
use App\Dto\ReturnUploadEntryDto;

class UploadEntryService implements UploadEntryServiceInterface 
{
    public function __construct(
        private readonly UploadEntryRepositoryInterface $uploadEntryRepository,
        private readonly string $uploadDirectory,
        private readonly FileUploadServiceInterface $fileUpload
    ) {}
    
    #[\Override]
    public function uploadEntry(UploadEntryDto $uploadEntryDto): bool 
    {
        $uploadEntry = new UploadEntry();

        $file = $uploadEntryDto->file;
        if(!empty($file)) {
            $file = $this->fileUpload->upload($file, $this->uploadDirectory);
            $uploadEntry->setImageName($file->getFilename());
            $uploadEntry->setImageExtension($file->getExtension());
        }

        $uploadEntry->setName($uploadEntryDto->name);
        $uploadEntry->setSurname($uploadEntryDto->surname);

        $this->uploadEntryRepository->save($uploadEntry);
        return true;
    }

    #[\Override]
    public function getAllEntries(): array
    {
        $dtos = array();
        $uploadedEntries = $this->uploadEntryRepository->fetchAll();
        foreach($uploadedEntries as $uploadedEntry) {
           $dto = new ReturnUploadEntryDto($uploadedEntry->getName(),
                   $uploadedEntry->getSurname(),
                   $uploadedEntry->getImageName());
           
            $dtos[] = $dto;
        }
        
        return $dtos;
    }

}