<?php

namespace App\Tests\Service;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver as ImagickDriver;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Service\FileUploadServiceInterface;

class FileUploadServiceTest extends KernelTestCase
{
    public function testFileUpload(): void
    {
        $fileNameToSearch = "sample-image";
        $imageManager = new ImageManager(new ImagickDriver()); 
        $tempFilePath = sys_get_temp_dir() . '/sample_image.jpg';
        $imageManager->create(100,100)->save($tempFilePath);
        $file = new UploadedFile($tempFilePath,"sample_image.jpg",null,null,true);

        $container = $this->getContainer();
        $uploadPath = $container->getParameter("upload_directory");

        $uploadService = $this->getContainer()->get(FileUploadServiceInterface::class);
        $uploadService->upload($file,$uploadPath);
        $filesInFolder = scandir($uploadPath);
      
        $matchingFiles = array_filter($filesInFolder, function($file) use ($fileNameToSearch) {
            return str_contains($file,$fileNameToSearch);
        });

        $this->assertTrue(count($matchingFiles) > 0);

        foreach ($matchingFiles as $file) 
        {
            unlink("$uploadPath/$file");
        }
    }
}
