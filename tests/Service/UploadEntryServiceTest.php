<?php

namespace App\Tests\Service;

use App\Repository\UploadEntryRepositoryInterface;
use App\Service\UploadEntryServiceInterface;
use App\Dto\UploadEntryDto;
use App\Entity\UploadEntry;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver as ImagickDriver;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UploadEntryServiceTest extends KernelTestCase
{
    
    public function testUpload(): void
    {
        $this->mockRepostioryAndSaveMethod();
        $result =  $this->getUploadEntryService()
            ->uploadEntry(new UploadEntryDto("testName","testSurname"));

        $this->assertTrue($result);
    }

    // public function testGetListOfEntries(): void { 
    //     $uploadRepository = $this->createMock(UploadEntryRepositoryInterface::class);

    //     //$uploadRepository->expects($this->once())->method("fetchAll")->willReturn();
    // }

    private function createUploadEntryTestData(): array {
        return [
            
        ];
    }

    private function getUploadEntry(string $name, string $surname, string $imageName, string $imageExtension): UploadEntry {
        $uploadEntry = new UploadEntry();

        $uploadEntry->setName($name);
        $uploadEntry->setSurname($surname);
        $uploadEntry->setImageName($imageExtension);
        $uploadEntry->setImageExtension($imageExtension);

        return $uploadEntry;
    }

    private function mockRepostioryAndSaveMethod(): void 
    {
        $uploadRepository = $this->createMock(UploadEntryRepositoryInterface::class);
        $uploadRepository->expects(self::once())->method('save')->willReturn(true);
        
        $container = $this->getContainer();
        $container->set(UploadEntryRepositoryInterface::class,$uploadRepository);
    }

    private function getUploadEntryService(): UploadEntryServiceInterface {
        return $this->getContainer()->get(UploadEntryServiceInterface::class);        
    }
}
