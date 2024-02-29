<?php
namespace App\Service;

use App\Dto\UploadEntryDto;
use App\Repository\UploadEntryRepositoryInterface;
use App\Entity\UploadEntry;

class UploadEntryService implements UploadEntryServiceInterface 
{
    public function __construct(
        private readonly UploadEntryRepositoryInterface $uploadEntryRepository,
        private readonly string $uploadDirectory
    ) {}

    public function uploadEntry(UploadEntryDto $uploadEntryDto): bool 
    {
        $uploadEntry = new UploadEntry();

        $file = $uploadEntryDto->file;
        if($file != null) {
            $uploadEntry->setImageName($file->getFilename());
            $uploadEntry->setImageExtension($file->getExtension());
        }

        $uploadEntry->setName($uploadEntryDto->name);
        $uploadEntry->setSurname($uploadEntryDto->surname);

        $this->uploadEntryRepository->save($uploadEntry);
        return true;
    }

    public function getUploadDirectoryPath(): string {
        return $this->uploadDirectory;
    }
}