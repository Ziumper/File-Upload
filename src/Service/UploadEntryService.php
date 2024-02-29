<?php
namespace App\Service;

use App\Dto\UploadEntryDto;
use App\Repository\UploadEntryRepositoryInterface;
use App\Entity\UploadEntry;
use Symfony\Component\String\Slugger\SluggerInterface;

class UploadEntryService implements UploadEntryServiceInterface 
{
    public function __construct(
        private readonly UploadEntryRepositoryInterface $uploadEntryRepository,
        private readonly string $uploadDirectory,
        private SluggerInterface $slugger
    ) {}

    public function uploadEntry(UploadEntryDto $uploadEntryDto): bool 
    {
        $uploadEntry = new UploadEntry();

        $file = $uploadEntryDto->file;
        if($file != null) {
            $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = $this->slugger->slug($originalFilename);
            $fileName = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();
            $movedfile = $file->move($this->getUploadDirectoryPath(),$fileName);
            $uploadEntry->setImageName($movedfile->getFilename());
            $uploadEntry->setImageExtension($movedfile->getExtension());
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