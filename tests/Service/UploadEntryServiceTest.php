<?php

namespace App\Tests\Service;

use App\Repository\UploadEntryRepositoryInterface;
use App\Service\UploadEntryServiceInterface;
use App\Dto\UploadEntryDto;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver as ImagickDriver;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UploadEntryServiceTest extends KernelTestCase
{
    public function setUp(): void {
        $this->mockRepostiory();
    }

    public function testUpload(): void
    {
        $result =  $this->getUploadEntryService()
            ->uploadEntry(new UploadEntryDto("testName","testSurname"));

        $this->assertTrue($result);
    }

    public function testUploadImage(): void 
    {
        $imageManager = new ImageManager(new ImagickDriver()); 
        $tempFilePath = sys_get_temp_dir() . '/sample_image.jpg';
        $imageManager->create(100,100)->save($tempFilePath);
        $file = new UploadedFile($tempFilePath,"sample_image.jpg",null,null,true);
        $uploadEntry = new UploadEntryDto("testName","testSurname",$file);

        $uploadService = $this->getUploadEntryService();
        $uploadService->uploadEntry($uploadEntry);
        $uploadPath = $uploadService->getUploadDirectoryPath();

        $this->assertEquals($uploadPath,$uploadEntry->file->getPath());
    }

    private function mockRepostiory(): void 
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
