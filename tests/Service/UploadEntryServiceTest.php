<?php

namespace App\Tests\Service;

use App\Repository\UploadEntryRepositoryInterface;
use App\Service\UploadEntryServiceInterface;
use App\Dto\UploadEntryDto;
use App\Entity\UploadEntry;
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

    public function testGetListOfEntries(): void { 
        $objects = $this->createUploadEntryTestData();
        $uploadRepository = $this->createMock(UploadEntryRepositoryInterface::class);
        $uploadRepository->expects($this->once())->method("fetchAll")->willReturn($objects);

        $container = $this->getContainer();
        $container->set(UploadEntryRepositoryInterface::class,$uploadRepository);
        
        $uploadEntryService = $container->get(UploadEntryServiceInterface::class);
        $entries = $uploadEntryService->getAllEntries();
        $this->assertCount(10,$entries);
        
        for($i = 0; $i < count($entries); $i++) {
            
            $entry = $entries[$i];
            $object = $objects[$i];
            
            $this->assertEquals($entry->name, $object->getName());
            $this->assertEquals($entry->surname, $object->getSurname());
            $this->assertEquals($entry->fileName, $object->getImageName());
        }
    }

    private function createUploadEntryTestData(): array {

        $uploadedEntries = [];
        for($i = 0; $i < 10;$i++) {
            $uploadEntry = $this->getUploadEntry("testName$i","testSurname$i","image-name$i.jgp","jpg");
            $uploadedEntries[] = $uploadEntry;
        }
        
        return $uploadedEntries;
    }

    private function getUploadEntry(string $name, string $surname, string $imageName, string $imageExtension): UploadEntry {
        $uploadEntry = new UploadEntry();
        $uploadEntry->setName($name);
        $uploadEntry->setSurname($surname);
        $uploadEntry->setImageName($imageName);
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
